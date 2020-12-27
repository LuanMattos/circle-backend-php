<?php
namespace Repository\Domain\Follower;
use Repository\GeneralRepository;

class FollowerRepository extends GeneralRepository{
    function __construct(){
        parent::__construct();
        $this->load->model('follower/Follower_model');
        $this->load->model('user/User_model');
    }

    public function getFollowerByUserName( $userId ){

        $fields = [
            'u.user_name',
            'u.user_avatar_url',
            'u.user_cover_url',
            'u.user_full_name'
        ];

        $followers = $this->Follower_model->getWhere( ['user_id_to' => $userId], "array", "follower_date", "ASC", "10", "0" );

        $users = [];
        foreach ( $followers as $key => $row ){
            $user = $this->db
                        ->select( $fields )
                        ->from('user u')
                        ->where(['u.user_id'=>$row['user_id_from']])->get()->row();
            array_push($users, $user);
        }
        return $users;
    }

}