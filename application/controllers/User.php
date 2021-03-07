<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Modules\Account\RestoreAccount;
use Modules\Storage\CreateFolderUserRepository as Upload;
use Repository\Modules\Auth;
use Repository\Core;
use Services\Domain\User\UserService;
use Repository\Domain\User as UserRepository;
use Services\Domain\Storage\StorageService;


class User extends Home_Controller
{
    private $jwt;
    private $http;
    private $userService;
    private $userRepository;
    private $s3;

    public function __construct(){
        parent::__construct();
        $this->load->model("user/User_model");
        $this->load->model("follower/Follower_model");
        $this->load->library('email/mail');
        $this->load->model('location/Location_model');

        $this->jwt = new Auth\Jwt();
        $this->http = new Core\Http();
        $this->userService = new UserService\UserService();
        $this->userRepository = new UserRepository\UserRepository();
        $this->s3 = new StorageService\StorageService();

    }

    public function login(){
        $data = $this->http::getDataHeader();

        if( $data )
            $user = $this->userService::validaDataLogin( $data );

            $newData = [
                "user_id"                => $user->user_id,
                "user_name"              => $user->user_name,
                "user_full_name"         => $user->user_full_name,
                "user_email"             => $user->user_email,
                "description"            => $user->description,
                "address"                => $user->address,
                "user_device_id"         => $user->system_data_information_device_id,
                'monetization_sent'      => $user->monetization_sent == 't'?true:false,
                "verified"               => empty($user->user_code_verification) || !$user->user_code_verification?true:false
            ];

            $this->jwt->encode( $newData );
            $this->response( $newData );
    }

    public function signUpOrSignInWithGoogle(){
        $data = $this->http::getDataHeader();
        $userExists = $this->userService::userExistsUserEmail( $data->data->email );

        if( $data->isNewUser && !$userExists ){
            $userData = $this->userService::validaDataRegisterAuthGoogle( $data->data );

            $user = [
                'user_name'     => $userData->user_name,
                'user_email'    => $userData->email,
                'user_full_name'=> $userData->name,
                'user_password' => password_hash( md5($userData->name.$userData->email.date('Y-m-d H:i:s').uniqid(rand(0,10000))), PASSWORD_ARGON2I ),
                'user_avatar_url' => $userData->picture,
                'user_token' => md5($userData->user_name.$userData->user_email)
            ];


            $this->userService->saveUserRegister( $user );

            $user = $this->userRepository->getUserByUserName($userData->user_name);

            $data = [
                'user_id'           => $user->user_id,
                'user_avatar_url'   => $user->user_avatar_url,
                'user_cover_url'    => $user->user_cover_url,
                'user_full_name'    => $user->user_full_name,
                'user_email'        => $user->user_email,
                'user_name'         => $user->user_name,
                'address'           => $user->address,
                'description'       => $user->description,
                'user_followers'    => $user->user_followers,
                'user_following'    => $user->user_following,
                'monetization_sent' => $user->monetization_sent == 't'?true:false,
                'verified'          => empty($user->user_code_verification) || !$user->user_code_verification?true:false

            ];
            $this->jwt->encode( $data );
            $this->response(true,'success');
        }else{
//            Rever segurança
            $dataUser = $this->userRepository->getUserByUserEmail( $data->data->email );
            $user = [
                'user_id'  => $dataUser->user_id,
                'user_token' => md5($dataUser->user_name.$dataUser->user_email)
            ];

            $this->userService->saveUserRegister( $user );
            $this->loginWithGoogle( $data->data );
        }
    }

    public function loginWithGoogle( $data ){
        if( $data )
            $user = $this->userService::validaDataLoginWithGoogle( $data );

            $newData = [
                "user_id"                => $user->user_id,
                "user_name"              => $user->user_name,
                "user_full_name"         => $user->user_full_name,
                "user_email"             => $user->user_email,
                "description"            => $user->description,
                "address"                => $user->address,
                "user_device_id"         => $user->system_data_information_device_id,
                'monetization_sent'      => $user->monetization_sent == 't'?true:false,
                "verified"               => empty($user->user_code_verification) || !$user->user_code_verification?true:false
            ];

            $this->jwt->encode( $newData );
            $this->response( $newData );
    }

    public function register(){
        $data = $this->userService::validaDataRegister( $this->http::getDataHeader() );

        $code = new RestoreAccount\AccountService();
        $codigoVerificacao = $code->generateCode();

        $user = [
            'user_name'              => $data->userName,
            'user_email'             => $data->email,
            'user_full_name'         => $data->fullName,
            'user_password'          => password_hash( $data->password, PASSWORD_ARGON2I ),
            'user_code_verification' => $codigoVerificacao
        ];


        $this->userService->saveUserRegister( $user );
        $this->response(true,'success');
    }

    public function userExists(){
        $userName =  $data = $this->http->getDataUrl(2);
        $this->userService::userExistsUserName( $userName );
    }

    public function userExistsEmail(){
        $data =  $this->http::getDataHeader();
        $user = $this->userService::userExistsUserEmail( $data->userEmail );
        if($user){
            $this->response(true);
        }else{
            $this->response(false);
        }
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

        $user = $this->User_model->getWhere(['user_name'=>$userHeader->user_name],'row');

        $pass = $user->user_password;

        if( ($data->userPassword && $data->userPasswordChange) && (!empty($data->userPassword) && !empty($data->userPasswordChange)) ) {
            if ($data->userPasswordChange):
                $newPass = password_hash($data->userPasswordChange, PASSWORD_ARGON2I);
            endif;
            $verify = password_verify( $data->userPassword,$user->user_password );

            if( !$verify ):
                $this->response(false,'error');
            else:
                $newData = [
                    'user_id'       => $user->user_id,
                    'user_password' => substr($newPass,0,250),
                    'user_email'    => substr($data->userEmail,0,250),
                    'address'       => substr($data->userAddress,0,400),
                    'description'   => addslashes( substr($data->userDescription,0,99) ),
                ];

                $this->User_model->save( $newData );
                $this->response('auth');
            endif;
        }else{
            $newData = [
                'user_id'       => $user->user_id,
                'user_email'    => substr($data->userEmail,0,250),
                'address'       => substr($data->userAddress,0,400),
                'description'   => addslashes( substr($data->userDescription,0,99) ),
            ];

            $this->User_model->save( $newData );
            $this->response('common');
        }
    }

    public function uploadImgProfile(){
        $jwtData = $this->jwt->decode();
        $user = $this->User_model->getWhere( ["user_id"=>$jwtData->user_id],"row" );

        $this->s3->saveImage( $user, $_FILES['imageFile'], NULL, 'avatar' );

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
        ];

        $this->jwt->encode( $newData );

    }

    public function uploadImgCover(){

        $jwtData = $this->jwt->decode();
        $user = $this->User_model->getWhere( ["user_id"=>$jwtData->user_id],"row" );

        $this->s3->saveImage( $user, $_FILES['imageFile'], NULL, 'cover' );

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
        ];

        $this->jwt->encode( $newData );

        $this->jwt->decode();

    }

    public function dataUserBasic(){
        $userName = $this->http->getDataUrl(2);

        $dataJwt = $this->jwt->decode();

        $user = $this->User_model->getWhere( ["user_name"=>$userName],"row" );

        $data = [
            'user_id'           => $user->user_id,
            'user_avatar_url'   => $user->user_avatar_url,
            'user_cover_url'    => $user->user_cover_url,
            'user_full_name'    => $user->user_full_name,
            'user_email'        => $user->user_email,
            'user_name'         => $user->user_name,
            'address'           => $user->address,
            'description'       => $user->description,
            'following'         => $this->followingOwner( $dataJwt, $user->user_id ),
            'user_followers'    => $user->user_followers,
            'user_following'    => $user->user_following,
            'monetization_sent' => $user->monetization_sent == 't'?true:false,
            'verified'          => empty($user->user_code_verification) || !$user->user_code_verification?true:false

        ];
        $this->jwt->encode( $data );

        $this->response( $data );

    }

    public function dataUserBasicNotAuth(){
        $userName = $this->http->getDataUrl(2);

        $user = $this->User_model->getWhere( ["user_name"=>$userName],"row" );

        $data = [
            'user_id'           => $user->user_id,
            'user_avatar_url'   => $user->user_avatar_url,
            'user_cover_url'    => $user->user_cover_url,
            'user_full_name'    => $user->user_full_name,
            'user_name'         => $user->user_name,
            'description'       => $user->description,

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
        $data    = $this->http::getDataHeader();
        $dataJwt = $this->jwt->decode();
        $user = $this->User_model->getWhere( ["user_name" => $dataJwt->user_name, 'user_code_verification' => $data ],"row" );
        $this->db->update('user', ['user_code_verification' => null],["user_id" => $dataJwt->user_id ] );

        if( $user ){
            $newData = [
                "id"       => $user->user_id,
                "name"     => $user->user_name,
                "fullName" => $user->user_full_name,
                "email"    => $user->user_email,
            ];
            $this->jwt->encode( $newData );
        }
    }

    public function forgotPassword(){
        $dataHeader    = $this->http::getDataHeader();

        $this->userService->forgotPassword( $dataHeader );
    }

    public function ChangePass(){
        $dataHeader = $this->http::getDataHeader();

        if( ( $dataHeader->password === $dataHeader->repPassword ) && ( $dataHeader->code ) ){
            $pass = password_hash( $dataHeader->password, PASSWORD_ARGON2I );
            $this->userService->changePassowrd( $dataHeader->code, $pass );
            $this->response('Senha atualizada');
        }
        $this->response('Tempo excedido para esta solicitação, tente novamente!');
    }

    public function refreshToken(){
        $dataJwt   = $this->jwt->decode();
        $user = $this->User_model->getWhere( ["user_name"=>$dataJwt->user_name, 'user_code_verification'=>null],"row" );

        $data = [
            'user_id'         => $user->user_id,
            'user_avatar_url' => $user->user_avatar_url,
            'user_cover_url'  => $user->user_cover_url,
            'user_full_name'  => $user->user_full_name,
            'user_email'      => $user->user_email,
            'user_name'       => $user->user_name,
            'address'         => $user->address,
            'description'     => $user->description,
            'user_followers'  => $user->user_followers,
            'user_following'  => $user->user_following,
            'monetization_sent' => $user->monetization_sent == 't'?true:false,
            "verified"        => empty($user->user_code_verification) || !$user->user_code_verification?true:false

        ];

        $this->jwt->encode( $data );
        $this->response();
    }

    public function verificationAcountConfirm(){
        $user = $this->jwt->decode();
        $result = $this->userRepository->AccountIsVerified( $user->user_id );

        $this->response( $result );
    }
    public function logout(){
        $user = $this->jwt->decode();
        $dataUser = $this->userRepository->getUserByUserName( $user->user_name );
        $this->userService->saveUserRegister( [
            'user_id'=>$dataUser->user_id,
            'user_token'=>''
        ] );

    }
}
//$datetime1 = new DateTime( $timeAccess );
//$datetime2 = new DateTime( date("d-m-Y H:i:s") );
//$interval = $datetime1->diff( $datetime2 );
//debug($interval);