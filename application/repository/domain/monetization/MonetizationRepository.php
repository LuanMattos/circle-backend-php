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
        $this->load->model('monetization/Trading_model');
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
            if($userLogged->user_id === $userNotGuest->user_id){
                self::Success("Que feio seu amigo não vai gostar de você se auto beneficiar!");
            }
            $trading = $this->Trading_model->getWhere([], "row", "trading_id", "DESC", 1);
            $data = [];
            $data['user_guest_id'] = $userId;
            $data['user_id'] = $userNotGuest->user_id;
            $data['user_vpi'] = 0;
            $data['user_mpc'] = number_format($trading->trading_mpc,2,".",",");
            $this->Monetization_model->save($data);
            $this->User_model->save(['user_id' => $userId, 'monetization_sent' => 't']);
            self::Success("success");
        }else{
            self::Success("Ops! Parece que você já validou seu ticket com algum usuário");
        }
    }
    public function getDataDashboard( $jwt ){
        $data = [];
        $trading = $this->Trading_model->getWhere([], "row", "trading_id", "DESC", 1);
        $data['mpc'] = $trading->trading_mpc;
        $data['count_registered'] = $this->getAllRegisteredByUserCount( $jwt );
        $data['total'] = 0;
        $invites = $this->Monetization_model->getWhere(['user_id'=>$jwt->user_id], "array");
        foreach ($invites as $row){
            $data['total'] += $row['user_mpc'];
        }
        self::Success($data);
    }
    public function getAllRegisteredByUserCount( $jwt ){
        return $this->db->select("count(user_monetization_id)")
            ->from('user_monetization')
            ->where(['user_id'=>$jwt->user_id])
            ->get()
            ->row()->count;
    }

}