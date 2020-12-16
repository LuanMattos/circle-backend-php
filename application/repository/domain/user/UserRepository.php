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
        return $this->User_model->getWhere( ['user_name' => $userName ], $return );
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
}