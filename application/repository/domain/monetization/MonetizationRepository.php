<?php
namespace Repository\Domain\Monetization;
use Repository\GeneralRepository;

class MonetizationRepository extends GeneralRepository
{
    private static $monetization;
    function __construct()
    {
        parent::__construct();
        $this->load->model('monetization/Monetization_model');
        $this->load->model('user/User_model');
    }
    public function saveMonetizationConfirmUser( $userId, $userName ){
        $userLogged = $this->User_model->getWhere(['user_id'=>$userId],'row');
        if( $userLogged->monetization_sent == 'f') {
            if (!$userName) {
                self::Success("Invalid Email!");
                exit();
            }
            $userNotGuest = $this->User_model->getWhere(['user_name' => $userName], "row");
            $data = [];
            $data['user_guest_id'] = $userId;
            $data['user_id'] = $userNotGuest->user_id;
            $this->Monetization_model->save($data);
            $this->User_model->save(['user_id' => $userId, 'monetization_sent' => 't']);
            self::Success("success");
        }else{
            self::Success("Ops! Parece que você já validou seu ticket com algum usuário");
        }
    }
}