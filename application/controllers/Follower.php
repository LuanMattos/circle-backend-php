<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Follower extends Home_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model("likes/Likes_model");
        $this->load->model("user/User_model");
        $this->load->model("photos/Photos_model");
        $this->load->model("follower/Follower_model");
    }

    public function follow(){
        $follow = false;
        $dataTo = $this->getDataUrl(2);
        $data   = $this->dataUserJwt('x-access-token');

        $user = $this->User_model->getWhere(['user_name'=>$data->user_name],"row");

        if( !$user ){
            $this->response('Usuário não existe','error');
        }

        $data = ['user_id_from'=>$user->user_id,'user_id_to'=>$dataTo];

        $hasFollow = $this->Follower_model->getWhere( $data );

        if( !$hasFollow ){
            $save = $this->Follower_model->save( $data );
            if( $save )
            $follow = true;
        }else{
            $this->Follower_model->deletewhere( $data );
        }

        $this->response( $follow );
    }
}
