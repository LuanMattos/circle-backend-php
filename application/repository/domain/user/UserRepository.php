<?php
namespace Repository\Domain\User;
use Repository\GeneralRepository;

class UserRepository extends GeneralRepository{
    private $jwt;

    function __construct(){
        parent::__construct();
        $this->load->model('user/User_model');
        $this->load->model('log/Log_access_model');
    }

    public function updateUserByUserName( Array $fields ){
        $this->db->update('user', $fields, ['user_name' => $fields['user_name'] ],1);
    }

    public function getUserByUserName( $userName, $return = "row"){
        $user = $this->User_model->getWhere( ['user_name' => $userName ], $return );
        if(!$user){
            self::Success('User does not exist!','error');
        }
        return $user;
    }

    public function getUserByUserEmail( $email, $return = "row"){
        $user = $this->User_model->getWhere( ['user_email' => $email ], $return );
        if(!$user){
            self::Success('User does not exist!','error');
        }
        return $user;
    }
    public function getUserByUserNameValidateCodeVerification( $userName, $return = "row"){
        $user = $this->User_model->getWhere( ['user_name' => $userName,'user_code_verification' => null ], $return );
        if(!$user){
            self::Success('User does not exist!','error');
        }
        return $user;
    }

    public function getUserByCodeLink( $code, $return = "row"){
        $user = $this->User_model->getWhere( ['user_link_forgot_password' => $code ], $return );
        if(!$user){
            self::Success('User does not exist!','error');
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

    public function validateUser( $userEmail ){
        $user = $this->db->select('*')
            ->from('user u')
            ->where('u.user_email',"$userEmail")
            ->where('u.user_blocked','f')
            ->or_where('u.user_code_verification',null)
            ->or_where('u.user_code_verification','')
            ->or_where('u.user_code_verification',null)
            ->get()
            ->result_array();
        if( !$user ){
            self::Success('Unverified user!','error');
        }

    }

    public function AccountIsVerified( $userId ){
        $user = $this->User_model->getWhere( ['user_id' => $userId], 'row');
        if( $user && (!$user->user_code_verification || empty( $user->user_code_verification )) ){
            return true;
        }
        return false;
    }

    public function getAllUsers($andWhere = ""){
        return $this->db->query("SELECT * FROM square.user where user_id >= 12043 and  user_email NOT ILIKE '%@mycircle.click' " . $andWhere)->result_array();
    }
}