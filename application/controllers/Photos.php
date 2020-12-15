<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Modules\Storage\Create_folder_user as Upload;
use Services\Modules\Auth;
use Services\Cor;

class Photos extends Home_Controller
{
    private $jwt;
    private $http;

    public function __construct(){
        parent::__construct();
        $this->load->model("photos/Photos_model");
        $this->load->model("user/User_model");

        $this->jwt = new Auth\Jwt();
        $this->http = new Cor\Http();
    }

    public function index(){
        $data = $this->http->getDataUrl(2);


        $offset = $this->input->get('page',true);

        $user = $this->User_model->getWhere( ['user_name'=>$data ],'row' );

        if( !$user ):
            $this->response('Usuário não existe','error');
        endif;

        $photos = $this->Photos_model->getPhotoUser(
            $user->user_id,$dataJwt, "photo_id","DESC", "9",$offset
        );

        $newData = [
            "user_id" => $user->user_id,
            "user_name" => $user->user_name,
            "user_full_name" => $user->user_full_name,
            "user_email" => $user->user_email,
            "description" => $user->description,
            "address" => $user->address,
            "user_avatar_url"=>$user->user_avatar_url,
            "user_code_verification" => $user->user_code_verification ? true : false
        ];

        $this->jwt->encode($newData );

        $this->response( $photos );

    }
    public function upload(){
        $datapost = (object)$this->input->post(null,true);

        $jwtData = $this->jwt->decode();

        $user = $this->User_model->getWhere( ["user_id"=>$jwtData->user_id],"row" );

        if( !$user ):
            $this->response('Usuário não existe!','error');
        endif;

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
        ];


        $this->jwt->encode($newData );


        new Upload\Create_folder_user( $_FILES, $user,$datapost );

    }
    public function getPhotoId(){
        $uri  = $this->uri->slash_segment(2);
        $id = number( $uri );

        $data = $this->jwt->decode();

        if( (integer) $id )

        $dataResponse = $this->Photos_model->getWhere( [ 'photo_id' => $id ],"row");
        $dataResponse->liked = $data & $this->Likes_model->getWhere(['photo_id'=>$id,'user_id'=>$data->user_id],"row")?true:false;
        $this->response( $dataResponse );
    }
    public function getPhoto(){
        $uri  = $this->uri->slash_segment(2);
        $fileName = str_replace(['/','?','´'],'',$uri);
        $url = $this->Photos_model->getWhere( [ 'photo_url' => "https://be.mycircle.click/get_photo/{$fileName}" ],"row" );
        return $url;
    }

}
