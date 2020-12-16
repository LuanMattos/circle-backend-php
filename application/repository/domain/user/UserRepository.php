<?php
namespace Repository\Domain\User;
use Repository\GeneralRepository;

class UserRepository extends GeneralRepository{
    function __construct(){
        parent::__construct();
        $this->load->model('user/User_model');
        $this->load->model('log/Log_access_model');
    }

    public function getUserByUserName( $userName, $return = "row"){
        $user = $this->User_model->getWhere( ['user_name' => $userName ], $return );
        if(!$user){
            self::Success('Usuário não existe!','error');
        }
        return $user;
    }

    public function getUserByCodeLink( $code, $return = "row"){
        $user = $this->User_model->getWhere( ['user_link_forgot_password' => $code ], $return );
        if(!$user){
            self::Success('Usuário não existe!','error');
        }
        return $user;
    }

    public function deleteLogUser( $userId ){
        $this->Log_access_model->deletewhere( ['user_id' => $userId ] );
    }

    public function updateDeviceUser( $sdiDeviceID, $userId ){
        $this->db->update('user',
            [ 'user_device_id' => $sdiDeviceID ], ['user_id' => $userId],1);
    }

    public function userExistsEmail( $userEmail ){
        return $this->User_model->userExistsEmail( $userEmail );
    }

    public function userExistsUserName( $userName ){
        return $this->User_model->userExistsUserName( $userName );
    }

    public function saveUserRegister( $user ){
        return $this->User_model->save( $user, ['user_id','user_name','user_email','user_code_verification']);
    }

    public function distinctEmailOrUserName( $dataHeader ){
        if(filter_var( $dataHeader, FILTER_VALIDATE_EMAIL )){
            $user = $this->User_model->getWhere( ["user_email" => $dataHeader ],"row" );
        }else{
            $user = $this->User_model->getWhere( ["user_name" => $dataHeader ],"row" );
        }
        return $user;
    }

    public function updateCodeVerificationUser( $codeVerification, $userId ){
        $this->db->update('user', ['user_code_verification' => $codeVerification],["user_id" => $userId ] );
    }

    public function updateLinkForgotPass( $codeVerification, $userId ){
        $this->db->update('user', ['user_link_forgot_password' => $codeVerification],["user_id" => $userId ] );
    }

    public function changePassowrd( $code, $pass ){
        $this->db->update('user', ['user_password'=>$pass,'user_blocked'=>null,'user_link_forgot_password'=>null],[ 'user_link_forgot_password'=>$code ] );
    }
}