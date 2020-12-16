<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Repository\Modules\Auth;
use Repository\Core;

class Likes extends Home_Controller
{
    private $jwt;
    private $http;

    public function __construct(){
        parent::__construct();
        $this->load->model("likes/Likes_model");
        $this->load->model("user/User_model");
        $this->load->model("photos/Photos_model");

        $this->jwt = new Auth\Jwt();
        $this->http = new Core\Http();
    }

    public function like(){
        $data = $this->http::getDataHeader();
        $userDecode = $this->jwt->decode();

        $this->db->trans_start();
            $user = $this->User_model->getWhere(['user_name' => $userDecode->user_name ],"row");

            $save = [
                'photo_id' => $data->photoId,
                'user_id' => $user->user_id
            ];
            $hasLiked = $this->Likes_model->getWhere( $save );

            if( $hasLiked ):
                $likesUnLiked = $this->Likes_model->countLikesPhotoId( $data->photoId );
                $this->Likes_model->deletewhere( $save );
                $countLiked =  $likesUnLiked  > 0 ?  $likesUnLiked  - 1:0;
            else:
                $likesLiked = $this->Likes_model->countLikesPhotoId( $data->photoId );
                $this->Likes_model->save( $save );
                $countLiked =  $likesLiked  + 1;
            endif;
            $save = [
                'photo_id'=>$data->photoId,
                'photo_likes'=>$countLiked,
            ];
            $this->Photos_model->save( $save,["photo_id"] );
        $this->db->trans_complete();

        $return = [
            'count'=>$countLiked,
            'liked'=>$this->Likes_model->likedMe( $data->photoId,$user->user_id )?true:false
        ];

        $this->response( $return );
    }

}
