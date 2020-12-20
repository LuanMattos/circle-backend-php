<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Modules\Storage\CreateFolderUserRepository as Upload;
use Repository\Domain\Photo as Photo;
use Repository\Domain\User;
use Repository\Modules\Auth;
use Repository\Core;
use Services\Domain\Storage\StorageService;
class Photos extends Home_Controller
{
    private $s3;
    private $jwt;
    private $http;
    private $photoRepository;
    private $userRepository;

    public function __construct(){
        parent::__construct();
        $this->load->model("photos/Photos_model");
        $this->load->model("user/User_model");

        $this->jwt = new Auth\Jwt();
        $this->http = new Core\Http();
        $this->photoRepository = new Photo\PhotoRepository();
        $this->userRepository = new User\UserRepository();
        $this->s3 = new StorageService\StorageService();
    }

    public function index(){
        $data = $this->http->getDataUrl(2);
        $dataJwt = $this->jwt->decode();

        $offset = $this->input->get('page',true);

        $user = $this->User_model->getWhere( ['user_name'=>$data ],'row' );

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
            "user_avatar_url" => $user->user_avatar_url,
            "user_code_verification" => $user->user_code_verification ? true : false
        ];

        $this->jwt->encode($newData );

        $this->response( $photos );

    }

    public function upload(){
        $datapost = (object)$this->input->post(null,true);

        $jwtData = $this->jwt->decode();

        $user = $this->User_model->getWhere( ["user_id"=>$jwtData->user_id],"row" );


        $this->s3->saveImage( $user, $_FILES['imageFile'], $datapost );

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
        ];

        $this->jwt->encode( $newData );
//Servidor de imagens próprio
//        new Upload\CreateFolderUserRepository( $_FILES, $user,$datapost );

    }

    public function getPhotoId(){
        $uri  = $this->http->getDataUrl(2);
        $id = number( $uri );

        $data = $this->jwt->decode();

        if( (integer) $id )

        $dataResponse = $this->Photos_model->getWhere( [ 'photo_id' => $id ],"row");
        $dataResponse->liked = $data & $this->Likes_model->getWhere(['photo_id'=>$id,'user_id'=>$data->user_id],"row")?true:false;
        $this->response( $dataResponse );
    }

    public function getPhoto(){
        $uri  = $this->http->getDataUrl(2);
        $fileName = str_replace(['/','?','´'],'',$uri);
        $url = $this->Photos_model->getWhere( [ 'photo_url' => "https://be.mycircle.click/get_photo/{$fileName}" ],"row" );
        return $url;
    }

    public function delete(){
        $photoId = $this->http->getDataUrl(2);
        $jwt = $this->jwt->decode();

        $user = $this->userRepository->getUserByUserName( $jwt->user_name );
        $this->photoRepository->deletePhotoByUser( $photoId, $user->user_id );
        $this->response();
    }

    public function updatePhoto(){
        $dataJwt = $this->jwt->decode();
        $header = $this->http::getDataHeader();
        if(strlen($header->photoDescription ) >= 900 ){
            $this->response('Máximo de 900 caractéres','error');
        }else{
            $this->photoRepository->updatePhoto( $header->photoId, $header->photoDescription, $dataJwt->user_id );
            $this->response(['photoDescription'=>$header->photoDescription]);
        }
    }

}
