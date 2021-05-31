<?php

namespace Services\Domain\User\UserService;

use Services\GeneralService;
use Repository\Domain\User;
use Repository\Modules\Log;
use Modules\Account\RestoreAccount;

class UserService extends GeneralService
{
    private static $userRepository;
    private static $systemDataInformationRepository;

    function __construct()
    {
        parent::__construct();
        static::$userRepository = new User\UserRepository();
        static::$systemDataInformationRepository = new Log\SystemDataInformationRepository();
    }

    public static function validaDataLogin($data)
    {
        debug($data);
        $sdi = static::$systemDataInformationRepository->saveDataInformation();

        $error = '';
        switch ($data) {
            case !$data->password:
                $error = "Password is required!";
                break;
            case !$data->userName:
                $error = "User name is required!";
                break;
        }
        $user = static::$userRepository->getUserByUserName($data->userName);

        switch ($user) {
            case !$user:
                $error = "Invalid user";
                static::$systemDataInformationRepository->saveAccessErrorUser($sdi);
                break;
            case ($user && ($user->user_blocked == 't')):
                $error = "Blocked user, reset your password!";
                break;
            case !password_verify($data->password, $user->user_password):
                $error = "Incorrect password!";
                static::$systemDataInformationRepository->saveAccessErrorPass($user);
                break;
        }

        if ($error):
            self::Success($error);
        endif;

        $sdiAuth = (object)static::$systemDataInformationRepository->saveDataInformation($user);

        static::$systemDataInformationRepository->compareAccessAndNotifyNewDevice($user, $sdiAuth);

        static::$userRepository->deleteLogUser($user->user_id);
        static::$userRepository->updateDeviceUser($sdiAuth->system_data_information_device_id, $user->user_id);
        static::$userRepository->saveUserRegister( [
            'user_id' => $user->user_id,
            'user_token' => md5($user->user_name.$user->user_email)
        ] );

        $user->system_data_information_device_id = $sdiAuth->system_data_information_device_id;

        return $user;
    }

    public static function validaDataLoginWithGoogle($data)
    {
        $sdi = static::$systemDataInformationRepository->saveDataInformation();

        $error = '';
        switch ($data) {
//            case !$data->password:
//                $error = "Password is required!";
//                break;
            case !$data->email:
                $error = "Email is required!";
                break;
        }
        $user = static::$userRepository->getUserByUserEmail($data->email);

        switch ($user) {
            case !$user:
                $error = "Invalid user";
                static::$systemDataInformationRepository->saveAccessErrorUser($sdi);
                break;
            case ($user && ($user->user_blocked == 't')):
                $error = "Blocked user, reset your password!";
                break;
//            case !password_verify($data->password, $user->user_password):
//                $error = "Incorrect password!";
//                static::$systemDataInformationRepository->saveAccessErrorPass($user);
//                break;
        }

        if ($error):
            self::Success($error);
        endif;

        $sdiAuth = (object)static::$systemDataInformationRepository->saveDataInformation($user);

        static::$systemDataInformationRepository->compareAccessAndNotifyNewDevice($user, $sdiAuth);

        static::$userRepository->deleteLogUser($user->user_id);
        static::$userRepository->updateDeviceUser($sdiAuth->system_data_information_device_id, $user->user_id);

        $user->system_data_information_device_id = $sdiAuth->system_data_information_device_id;

        return $user;
    }

    public static function signupWithGoogle($user)
    {
        static::$userRepository->saveUserRegister($user);
    }

    public static function validaDataRegisterAuthGoogle($data)
    {
        $error = "";
        switch ($data):
            case !$data->email || !filter_var($data->email, FILTER_VALIDATE_EMAIL):
                $error .= "Invalid email Try Later";
            case !$data->verified_email:
                $error .= "Email not verified";
        endswitch;


        $tentOne = str_replace(" ","",$data->name);
        $validaUserName = static::$userRepository->userExistsUserName( $tentOne );

        if( $validaUserName ){
            $partes = explode("@", $data->email);
            $userNameMail = $partes[0];
            $data->user_name = $userNameMail . substr($userNameMail,0,rand(1,count($userNameMail)));
            $validaUserName = static::$userRepository->userExistsUserName( $data->user_name );

            if( $validaUserName ){
                $data->user_name = $userNameMail.$tentOne;
                $validaUserName = static::$userRepository->userExistsUserName( $data->user_name );
                if( $validaUserName ){
                    $data->user_name = $data->email;
                }
            }
        }else{
            $data->user_name = $tentOne;
        }


        if ($error):
            self::Success($error, 'error');
        endif;
        return $data;
    }

    public static function validaDataRegister($data)
    {
        $error = "";
        switch ($data):
            case !$data->email || !filter_var($data->email, FILTER_VALIDATE_EMAIL):
                $error .= "Invalid email";
            case !$data->userName || strlen($data->userName) < 3:
                $error .= "Invalid user name";
            case !$data->fullName:
                $error .= "Invalid user name";
            case !$data->password || strlen($data->password) < 8:
                $error .= "Invalid password";
        endswitch;

        $user = static::$userRepository->userExistsUserName($data->user_name);
        $userEmail = static::$userRepository->userExistsEmail($data->email);

        if ($user || $userEmail) {
            $error = "User already registered ";
        }

        if ($error):
            self::Success($error, 'error');
        endif;
        return $data;
    }

    public function saveUserRegister($user)
    {
        $userSave = static::$userRepository->saveUserRegister($user);
        if ($userSave)
            $this->sendEmail($userSave);
    }

    public function forgotPassword($dataHeader)
    {
        $user = static::$userRepository->distinctEmailOrUserName($dataHeader);

        if (!$user) {
            $error = 'User not found!';
        }

        if ($error):
            self::Success($error, 'error');
        endif;

        $code = new RestoreAccount\AccountService();
        $codeLink = $code->generateCodeLink($user);

        $linkUri = 'https://mycircle.click/change-password/' . $codeLink;

        if (ENVIRONMENT === 'development') {
            $linkUri = 'http://localhost:4200/change-password/' . $codeLink;
        }

        self::$userRepository->updateLinkForgotPass($codeLink, $user->user_id);
        $user->user_link_forgot_password = $linkUri;
        $this->sendEmailForgotPassword($user);
        self::Success('Enviamos um E-mail de confirmação para a conta informada, clique no link e redefina sua senha.');

    }

    public function changePassowrd($code, $pass)
    {
        self::$userRepository->changePassowrd($code, $pass);
        $user = self::$userRepository->getUserByCodeLink($code);
        static::$userRepository->deleteLogUser($user->user_id);
    }

    private function sendEmailForgotPassword($user, $title = 'Relembrar Senha!')
    {
        $emailFrom = $this->config->item('email_account');

        $mail = new \Mail();
        $nome = $user->user_name;
        $param = [];
        $param['from'] = $emailFrom;
        $param['to'] = $user->user_email;
        $param['name'] = "Circle";
        $param['name_to'] = $user->user_name;
        $param['assunto'] = $title;
        $data['link'] = $user->user_link_forgot_password;
        $data['relembrar_senha'] = true;
        $data['nome'] = $nome;

        $html = $this->load->view("email/confirme", $data, true);
        $param['corpo'] = '';
        $param['corpo_html'] = $html;
        $mail->send($param);

    }

    private function sendEmail($user, $title = 'Ativação de conta Circle!')
    {
        $emailFrom = $this->config->item('email_account');

        $mail = new \Mail();
        $nome = $user['user_name'];
        $param = [];
        $param['from'] = $emailFrom;
        $param['to'] = $user['user_email'];
        $param['name'] = "Circle";
        $param['name_to'] = $user['user_name'];
        $param['assunto'] = $title;
        $data['codigo_confirmacao'] = $user['user_code_verification'];
        $data['cadastro'] = true;
        $data['nome'] = $nome;

        $html = $this->load->view("email/confirme", $data, true);
        $param['corpo'] = '';
        $param['corpo_html'] = $html;
        $mail->send($param);

    }

    public static function userExistsUserName($userName)
    {
        $user = static::$userRepository->userExistsUserName($userName);
        if ($user)
            self::Success(true);
    }

    public static function userExistsUserEmail($userEmail)
    {
        $user = static::$userRepository->userExistsEmail($userEmail);
        return $user;
    }

}