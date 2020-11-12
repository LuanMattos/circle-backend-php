<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Likes extends Home_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model("likes/Likes_model");
        $this->load->model("user/User_model");
        $this->load->model("photos/Photos_model");
    }

    public function index(){
        $uri  = $this->uri->slash_segment(2);
        $data = str_replace(['/','?','´'],'',$uri);

        $user = $this->User_model->getWhere( ['user_name'=>$data ],'row' );

        if( !$user ):
            $this->response('Usuário não existe','error');
        endif;

        $photos = $this->Photos_model->getWhere( [ 'user_id' => $user->user_id ] );

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
        ];


        $dados  = $this->generateJWT( $newData );
        $this->setHeaders( $dados,'x-access-token' );

        $this->response( $photos );

    }
    public function like(){
        $data = file_get_contents('php://input');
        $data ? $data = json_decode( $data ) : false;

        $this->db->trans_start();
            $user = $this->User_model->getWhere(['user_name' => $data->userName ],"row");

            if( !$user ){
                $this->response('Usuário não existe!','error');
            }

            $save = [
                'photo_id'=>$data->photoId,
                'user_id'=>$user->user_id
            ];
            $hasLiked = $this->Likes_model->getWhere( $save );

            if( $hasLiked ):
                $likesUnLiked = $this->Likes_model->getWhere(['photo_id' => $data->photoId ] );
                $this->Likes_model->deletewhere( $save );
                $countLiked = count( $likesUnLiked ) > 0 ? count( $likesUnLiked ) - 1:0;
            else:
                $likesLiked = $this->Likes_model->getWhere(['photo_id' => $data->photoId ] );
                $this->Likes_model->save( $save );
                $countLiked = count( $likesLiked ) + 1;
            endif;
            $save = [
                'photo_id'=>$data->photoId,
                'photo_likes'=>$countLiked,
            ];
            $photosSave = $this->Photos_model->save( $save,["photo_id"] );

        $this->db->trans_complete();

        $likesReturn = $this->Likes_model->getWhere( ['photo_id'=>$photosSave['photo_id']] );

        $this->response( $likesReturn );
    }

}
