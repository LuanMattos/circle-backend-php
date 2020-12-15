<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Modules\Account\RestoreAccount;
use Modules\Storage\Create_folder_user as Upload;
use Services\Modules\Auth;
use Services\Cor;

class User extends Home_Controller
{
    private $dataAccess;
    private $jwt;
    private $http;

    public function __construct(){
        parent::__construct();
        $this->load->model("user/User_model");
        $this->load->model("follower/Follower_model");
        $this->load->library('email/mail');
        $this->load->model('log/System_data_information_model');
        $this->load->model('location/Location_model');
        $this->load->model('log/Log_access_model');

        $this->jwt = new Auth\Jwt();
        $this->http = new Cor\Http();

    }

    public function login(){
        $sdi = $this->saveDataInformation();

        $data = $this->http::getDataHeader();

        if( $data )
            switch ( $data ){
                case !$data->password:
                    $error = "Password is required!";
                break;
                case !$data->userName:
                    $error = "User name is required!";
                break;
            }

            $user = $this->User_model->getWhere( ['user_name' => $data->userName ],"row" );

            switch ( $user ){
                case !$user:
                    $error = "Usuário inválido!";
                    $this->saveAccessErrorUser( $sdi );
                    break;
                case ($user && ($user->user_blocked == 't')):
                    $error = "Usuário bloqueado, redefina sua senha!";
                    break;
                case !password_verify( $data->password, $user->user_password ):
                    $error = "Senha incorreta!";
                    $this->saveAccessErrorPass( $user );
                    break;
            }

            if( $error ):
                $this->response( $error,"error" );
            endif;

            $sdiAuth = (object)$this->saveDataInformation( $user );

            $this->compareAccessAndNotifyNewDevice( $user, $sdiAuth );

            $this->Log_access_model->deletewhere(['user_id'=>$user->user_id]);

            $this->db->update('user',
                ['user_device_id' => $sdiAuth->system_data_information_device_id], ['user_id' => $user->user_id],1);

            $newData = [
                "user_id" => $user->user_id,
                "user_name" => $user->user_name,
                "user_full_name" => $user->user_full_name,
                "user_email" => $user->user_email,
                "description" => $user->description,
                "address" => $user->address,
                "user_code_verification" => $user->user_code_verification ? true : false,
                "user_device_id"=> $sdiAuth->system_data_information_device_id
            ];

            $this->jwt->encode( $newData );

            $this->response( $newData );
    }

    private function saveAccessErrorPass( $user ){
        $sdi = (object)$this->saveDataInformation( $user );
        if( $sdi && $user ) {
            $errorUser = [
                'user_id' => $user->user_id,
                'error_type_id' => 6,
                'system_data_information_id' => $sdi->system_data_information_id
            ];
            $this->Log_access_model->save( $errorUser );
            $this->saveLocation( $user->user_id );
            $this->dataAccess .= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT']: '';
            $this->compareAccessAndNotifyErrorPass( $user );
        }
    }

    private function saveAccessErrorUser( $sdi ){
        if( $sdi ) {
            $errorUser = [
                'error_type_id' => 7,
                'system_data_information_id' => $sdi->system_data_information_id
            ];
            $this->Log_access_model->save( $errorUser );
        }
    }

    private function saveDataInformation( $user = null){

        $sdiData = [
            'user_id'=>$user?$user->user_id:null,
            'system_data_information_user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'system_data_information_http_origin' => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '',
            'system_data_information_http_referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'system_data_information_remote_addr' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
            'system_data_information_host_name' => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '',
            'system_data_information_ip_by_host_name' => isset($_SERVER['HTTP_HOST']) ? gethostbyname($_SERVER['HTTP_HOST']) : '',
            'system_data_information_http_x_forwarded_for' => isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '',
            'system_data_information_device_id' => isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $user? md5($_SERVER['HTTP_X_FORWARDED_FOR'].$user->user_id) : '',
        ];

        return $this->System_data_information_model->save( $sdiData, ['system_data_information_id','system_data_information_http_x_forwarded_for','system_data_information_device_id','system_data_information_user_agent'] );
    }

    private function compareAccessAndNotifyErrorPass( $user ){
        $dataAccess = $this->dataAccess . ' no dia ' . date('d/m/Y ') . ' às ' . date('H:i:s');

        $attemptsAccess = $this->config->item('attempts_access');
        $access = $this->Log_access_model->getCountAccessByUser( $user->user_id );

        if( ($access >= $attemptsAccess)   ){
            $this->db->update('user',['user_blocked'=>'t'],['user_id'=>$user->user_id]);
            $this->sendEmailAccess( $user, $dataAccess );
        }
    }

    private function compareAccessAndNotifyNewDevice( $user, $deviceIdToCompare ){
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:set_val($_SERVER['REMOTE_ADDR']);
        $location = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

        $dataAccess = $deviceIdToCompare->system_data_information_user_agent . " - " . $location->city . " - " . $location->region;

        if(ENVIRONMENT === 'production') {
            if ($user->user_device_id !== $deviceIdToCompare->system_data_information_device_id) {
                $this->sendEmailNewDevice($user, $dataAccess);
            }
        }
    }

    private function sendEmailAccess( $user, $dataAccess ){
        $emailFrom = $this->config->item('email_account');

        if( ENVIRONMENT === 'production' ){
            $mail  = new Mail();
            $nome                       = $user->user_name;
            $param = [];
            $param['from']              = $emailFrom;
            $param['to']                = $user->user_email;
            $param['name']              = "Circle";
            $param['name_to']           = $user->user_name;
            $param['assunto']           = 'Aviso de acesso à sua conta Circle!';
            $data['accessAccount']      = true;
            $data['dataAccess']         = $dataAccess;
            $data['nome']               = $nome;

            $html = $this->load->view("email/confirme",$data,true);
            $param['corpo']      = '';
            $param['corpo_html'] = $html;
            $mail->send( $param );
        }
    }

    private function sendEmailNewDevice( $user, $dataAccess ){
        $emailFrom = $this->config->item('email_account');

        if(ENVIRONMENT === 'development'){
            debug('E-mail enviado!');
        }

        $mail  = new Mail();
        $nome                       = $user->user_name;
        $param = [];
        $param['from']              = $emailFrom;
        $param['to']                = $user->user_email;
        $param['name']              = "Circle";
        $param['name_to']           = $user->user_name;
        $param['assunto']           = 'Aviso de acesso à sua conta Circle!';
        $data['newDevice']          = true;
        $data['dataAccess']         = $dataAccess;
        $data['nome']               = $nome;

        $html = $this->load->view("email/confirme",$data,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;
        $mail->send( $param );

    }

    private function saveLocation( $userId ){
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:set_val($_SERVER['REMOTE_ADDR']);
        $location = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
        $data = [
            'user_id'=>$userId,
            'location_coordinates' => $location->loc,
            'location_city' => $location->city,
            'location_state' => $location->region,
            'location_country' => $location->country,
            'location_organization' => $location->org,
            'location_zip_code' => $location->postal,
            'location_time_zone' => $location->timezone,
            'location_hostname' => $location->hostname,
        ];
        $this->dataAccess = $location->city . "</br> - " . $location->region . "</br> - " . $location->country . "</br> - ";
        $this->Location_model->save($data);
    }

    public function register(){
        $data = $this->http::getDataHeader();
        $error = "";

        switch ( $data ):
            case !$data->email || !filter_var( $data->email, FILTER_VALIDATE_EMAIL ):
                $error .= "E-mail inválido";
            case !$data->userName || strlen( $data->userName ) < 3:
                $error .= "Nome de usuário inválido";
            case !$data->fullName:
                $error .= "Nome de usuário inválido";
            case !$data->password || strlen( $data->password ) < 8:
                $error .= "Senha inválida";
        endswitch;

        $user = $this->User_model->userExistsEmail( $data->user_name );
        $userEmail = $this->User_model->userExistsEmail( $data->user_email );

        if( $user || $userEmail ){
            $error = "Usuário já cadastrado ";
        }

        if( $error ):
            $this->response( $error,'error' );
        endif;

        $code = new RestoreAccount\AccountService();
        $codigoVerificacao = $code->generateCode();

        $user = [
            'user_name'=>$data->userName,
            'user_email'=>$data->email,
            'user_full_name'=>$data->fullName,
            'user_password'=>password_hash( $data->password, PASSWORD_ARGON2I ),
            'user_code_verification'=>$codigoVerificacao
        ];

        $userSave = $this->User_model->save( $user, ['user_id','user_name','user_email','user_code_verification']);

        if( $userSave )
        $this->sendEmail( $userSave );

    }

    private function sendEmail( $user ){
        $emailFrom = $this->config->item('email_account');

        $mail  = new Mail();
        $nome                       = $user['user_name'];
        $param = [];
        $param['from']              = $emailFrom;
        $param['to']                = $user['user_email'];
        $param['name']              = "Circle";
        $param['name_to']           = $user['user_name'];
        $param['assunto']           = 'Ativação de conta Circle!';
        $data['codigo_confirmacao'] = $user['user_code_verification'];
        $data['cadastro']           = true;
        $data['nome']               = $nome;

        $html = $this->load->view("email/confirme",$data,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;
        $mail->send( $param );

    }

    public function userExists(){
        $userName =  $data = $this->http->getDataUrl(2);
        $user = $this->User_model->userExistsUserName($userName);

        if( $user )
            $this->response(true);

    }

    public function search(){
        $data = $this->http::getDataHeader();
        $offset = $this->http->getDataUrl(2);

        if( $data )

        $users =  $this->User_model->searchUser( $data->name,$offset );
        $this->response( $users );
    }

    public function saveSetting(){
        $data = $this->http::getDataHeader();
        $userHeader = $this->jwt->decode();

        if( !$data->userEmail || !$data->userPassword ){
            $this->response('Os campos acima devem ser preenchidos!','error');
        }

        $user = $this->User_model->getWhere(['user_name'=>$userHeader->user_name],'row');

        if( !$user ):
            $this->response('Usuário não encontrado!','error');
        endif;

        $pass = $user->user_password;

        if( $data->userPasswordChange ):
            $pass = password_hash( $data->userPasswordChange,PASSWORD_ARGON2I );
        endif;

        $verify = password_verify( $data->userPassword,$user->user_password );

        if( !$verify ):
            $this->response('Senha Incorreta','error');
        endif;


        $newData = [
            'user_id'=>$user->user_id,
            'user_password'=>substr($pass,0,250),
            'user_email'=>substr($data->userEmail,0,250),
            'address'=>substr($data->userAddress,0,400),
            'description'=>addslashes( substr($data->userDescription,0,99) ),
        ];

        $this->User_model->save( $newData );
        $this->response('Salvo com sucesso');
    }

    public function uploadImgProfile(){
        $jwtData = $this->jwt->decode();

        $user = $this->User_model->getWhere( ["user_id"=>$jwtData->user_id],"row" );

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
        ];

        $this->jwt->encode( $newData );

        new Upload\Create_folder_user( $_FILES, $user,NULL,'avatar' );

    }

    public function uploadImgCover(){
        $jwtData = $this->jwt->encode();

        $user = $this->User_model->getWhere( ["user_id"=>$jwtData->user_id],"row" );

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
        ];

        $this->jwt->encode( $newData );

        new Upload\Create_folder_user( $_FILES, $user,NULL,'cover' );

    }

    public function dataUserBasic( ){
        $userName = $this->http->getDataUrl(2);

        $dataJwt = $this->jwt->decode();

        $user = $this->User_model->getWhere( ["user_name"=>$userName],"row" );

        $data = [
            'user_id'=>$user->user_id,
            'user_avatar_url'=>$user->user_avatar_url,
            'user_cover_url'=>$user->user_cover_url,
            'user_full_name'=>$user->user_full_name,
            'user_email'=>$user->user_email,
            'user_name'=>$user->user_name,
            'address'=>$user->address,
            'description'=>$user->description,
            'following'=>$this->followingOwner( $dataJwt, $user->user_id ),
            'user_followers'=>$user->user_followers,
            'user_following'=>$user->user_following
        ];

        $this->response( $data );

    }

    private function followingOwner( $dataJwt, $userIdUrl ){
        if( $dataJwt ):
            $data = [ 'user_id_from'=>$dataJwt->user_id, 'user_id_to'=>$userIdUrl ];
            return $this->Follower_model->getwhere( $data ) ? true : false;
        endif;
        return false;
    }

    public function verificationCode(){
        $data = $this->http::getDataHeader();
        $dataJwt = $this->jwt->decode();
        $user = $this->User_model->getWhere( ["user_name"=>$dataJwt->user_name, 'user_code_verification'=>$data],"row" );
        $this->db->update('user',['user_code_verification'=>null],["user_id"=>$dataJwt->user_id]);

        if( $user ){
            $newData = [
                "id" => $user->user_id,
                "name" => $user->user_name,
                "fullName" => $user->user_full_name,
                "email" => $user->user_email,
            ];
            $this->jwt->encode( $newData );
        }

    }

}
//$datetime1 = new DateTime( $timeAccess );
//$datetime2 = new DateTime( date("d-m-Y H:i:s") );
//$interval = $datetime1->diff( $datetime2 );
//debug($interval);