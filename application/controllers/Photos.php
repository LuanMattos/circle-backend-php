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
        $uri  = $this->uri->slash_segment(2);
        $data = str_replace(['/','?','´'],'',$uri);

        $offset = $this->input->get('page',true);

        $user = $this->User_model->getWhere( ['user_name'=>$data ],'row' );
       
        if( !$user ):
            $this->response('Usuário não existe','error');
        endif;
        $photos = $this->Photos_model->getWhere(
            [ 'user_id' => $user->user_id ],
            $result = "array",$orderby = "photo_post_date",$direction = "DESC",$limit = "9",$offset
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

        $header = apache_request_headers();
        $jwtData = $this->dataUserJwt( $header['x-access-token'] );

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
        if( (integer) $id )
        $url = $this->Photos_model->getWhere( [ 'photo_id' => $id ],"row");
        $this->response( $url );
    }
    public function getPhoto(){
        $uri  = $this->uri->slash_segment(2);
        $fileName = str_replace(['/','?','´'],'',$uri);
        $url = $this->Photos_model->getWhere( [ 'photo_url' => "http://localhost/get_photo/{$fileName}" ],"row" );
        return $url;
    }

}
