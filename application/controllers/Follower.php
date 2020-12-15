<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Services\Modules\Auth;
use Services\Cor;

class Follower extends Home_Controller
{
    private $jwt;
    private $http;

    public function __construct(){
        parent::__construct();
        $this->load->model("likes/Likes_model");
        $this->load->model("user/User_model");
        $this->load->model("photos/Photos_model");
        $this->load->model("follower/Follower_model");

        $this->jwt = new Auth\Jwt();
        $this->http = new Cor\Http();

    }

    public function follow(){
        $follow = false;
        $dataTo = $this->http->getDataUrl(2);
        $data   = $this->jwt->decode();

        $user = $this->User_model->getWhere(['user_name'=>$data->user_name],"row");

        if( !$user ){
            $this->response('Usuário não existe','error');
        }

        $data = ['user_id_from'=>$user->user_id,'user_id_to'=>$dataTo];

        $hasFollow = $this->Follower_model->getWhere( $data );

        if( !$hasFollow ){
            $seguindo = $this->Follower_model->countFollowingUserId( $user->user_id );

            $countSeguindo = $seguindo + 1;

            $save = $this->Follower_model->save( $data );
            if( $save )
            $follow = true;
        }else{
            $seguindo = $this->Follower_model->countFollowingUserId( $user->user_id );

            $countSeguindo = $seguindo > 0 ? $seguindo - 1:0;

            $this->Follower_model->deletewhere( $data );

            $follow = false;
        }

        $user = ['user_id'=>$user->user_id,'user_following'=>$countSeguindo];
        $this->User_model->save( $user );

        $countSeguindoTo = $this->Follower_model->countFollowersUserId( $dataTo );

        $user = ['user_id'=>$dataTo,'user_followers'=>$countSeguindoTo];
        $this->User_model->save( $user );

        $this->response( $follow );
    }
}
