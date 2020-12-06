<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Modules\Storage\Create_folder_user as Upload;

class Photos extends Home_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("photos/Photos_model");
        $this->load->model("user/User_model");
    }

    public function index(){
        $data = $this->getDataUrl(2);
        $dataJwt = $this->dataUserJwt('x-access-token');

        $offset = $this->input->get('page',true);

        $user = $this->User_model->getWhere( ['user_name'=>$data ],'row' );

        if( !$user ):
            $this->response('Usuário não existe','error');
        endif;

        $photos = $this->Photos_model->getPhotoUser(
            $user->user_id,$dataJwt, "photo_post_date","DESC", "9",$offset
        );

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
    public function upload(){
        $datapost = (object)$this->input->post(null,true);

        $jwtData = $this->dataUserJwt( 'x-access-token' );

        $user = $this->User_model->getWhere( ["user_id"=>$jwtData->user_id],"row" );

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
        ];


        $dados  = $this->generateJWT( $newData );
        $this->setHeaders( $dados,'x-access-token' );

        if( !$user ):
            $this->response('Usuário não existe','error');
        endif;
        new Upload\Create_folder_user( $_FILES, $user,$datapost );

    }
    public function getPhotoId(){
        $uri  = $this->uri->slash_segment(2);
        $id = number( $uri );

        $data = $this->dataUserJwt('x-access-token');

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
