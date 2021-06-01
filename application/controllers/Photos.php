<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Modules\Storage\CreateFolderUserRepository as Upload;
use Repository\Domain\Photo as Photo;
use Services\Domain\Photo as PhotoService;
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
    private $photoService;
    private $jwtIfExistsAuth;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("photos/Photos_model");
        $this->load->model("user/User_model");

        $this->jwt = new Auth\Jwt();
        $this->http = new Core\Http();
        $this->jwtIfExistsAuth = new Auth\Jwt(true);
        $this->photoRepository = new Photo\PhotoRepository();
        $this->photoService = new PhotoService\PhotoService();
        $this->userRepository = new User\UserRepository();
        $this->s3 = new StorageService\StorageService();
    }

    public function index()
    {
        $data = $this->http->getDataUrl(2);
        $dataJwt = $this->jwtIfExistsAuth->decodeIfExists();

        $offset = $this->input->get('page', true);

        $user = $this->User_model->getWhere(['user_name' => $data], 'row');

        $userLocal = $dataJwt;

        if (!$dataJwt) {
            $userLocal = $user;
        }

//        $this->userRepository->validateUser( $user->user_email );

        $photos = $this->Photos_model->getPhotoUser(
            $user->user_id, $userLocal, "photo_id", "DESC", "9", $offset
        );

        $newData = [
            "user_id" => $user->user_id,
            "user_name" => $user->user_name,
            "user_full_name" => $user->user_full_name,
            "user_email" => $user->user_email,
            "description" => $user->description,
            "address" => $user->address,
            "user_avatar_url" => $user->user_avatar_url,
            "verified" => empty($user->user_code_verification) || !$user->user_code_verification ? true : false
        ];

//        $this->jwt->encode($newData );

        $this->response($photos);

    }

    public function upload()
    {
        $datapost = (object)$this->input->post(null, true);

        $jwtData = $this->jwt->decode();

        $user = $this->User_model->getWhere(["user_id" => $jwtData->user_id], "row");

        if ($user->user_code_verification || !empty($user->user_code_verification)) {
            $this->response('Ops,  it looks like you havent verified your account yet!');
        }

        $this->s3->saveImage($user, $_FILES['imageFile'], $datapost);

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
            "verified" => empty($user->user_code_verification) || !$user->user_code_verification ? true : false
        ];

        $this->jwt->encode($newData);
//Servidor de imagens próprio
//        new Upload\CreateFolderUserRepository( $_FILES, $user,$datapost );

    }

    public function uploadVideo()
    {

        $datapost = (object)$this->input->post(null, true);

        $jwtData = $this->jwt->decode();

        $user = $this->User_model->getWhere(["user_id" => $jwtData->user_id], "row");

        if ($user->user_code_verification || !empty($user->user_code_verification)) {
            $this->response('Ops,  it looks like you havent verified your account yet!');
        }

        $this->s3->saveMovie($user, $_FILES['videoFile'], $datapost);

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
            "verified" => empty($user->user_code_verification) || !$user->user_code_verification ? true : false
        ];

        $this->jwt->encode($newData);

    }

    public function getPhotoId()
    {
        $uri = $this->http->getDataUrl(2);
        $id = number($uri);

        $data = $this->jwt->decode();

        if ((integer)$id)

            $dataResponse = $this->Photos_model->getWhere(['photo_id' => $id], "row");
        $dataResponse->liked = $data & $this->Likes_model->getWhere(['photo_id' => $id, 'user_id' => $data->user_id], "row") ? true : false;
        $this->response($dataResponse);
    }

    public function getPhoto()
    {
        $uri = $this->http->getDataUrl(2);
        $fileName = str_replace(['/', '?', '´'], '', $uri);
        $url = $this->Photos_model->getWhere(['photo_url' => "https://be.mycircle.click/get_photo/{$fileName}"], "row");
        return $url;
    }

    public function delete()
    {
        $photoId = $this->http->getDataUrl(2);
        $jwt = $this->jwt->decode();
        $user = $this->userRepository->getUserByUserName($jwt->user_name);
        $this->photoService->deletePhotoByUser($photoId, $user->user_id);
    }

    public function updatePhoto()
    {
        $dataJwt = $this->jwt->decode();
        $header = $this->http::getDataHeader();
        if (strlen($header->photoDescription) >= 900) {
            $this->response('Máximo de 900 caractéres', 'error');
        } else {
            $this->photoRepository->updatePhoto($header->photoId, $header->photoDescription, $dataJwt->user_id);
            $this->response(['photoDescription' => $header->photoDescription]);
        }
    }

    public function photosToExplorer()
    {
        $offset = $this->input->get('page', true);
        $dataJwt = $this->jwt->decode();

//        $user = $this->userRepository->getUserByUserNameValidateCodeVerification($dataJwt->user_name);
//        $user = $this->userRepository->getUserByUserName($dataJwt->user_name);
        $photo = $this->photoRepository->getPhotoToExplorer($offset);
        $this->response($photo);
    }

    public function photosTimeline()
    {
        $offset = $this->input->get('page', true);
        $dataJwt = $this->jwt->decode();
        $user = $this->userRepository->getUserByUserNameValidateCodeVerification($dataJwt->user_name);
        $photo = $this->photoRepository->getPhotoTimeline($offset, $user);
        $this->response($photo);
    }

    public function logErrorPhoto(){
        $photoId = $this->http->getDataUrl(2);
        $this->jwt->decode();
        $lastNumber = $this->photoRepository->getPhotoByIdAndUserId($photoId);
        $this->photoRepository->updatePhotoLogError($photoId, $lastNumber->log_error_count  + 1);
        $this->photoRepository->deletePhotoLogError($photoId, $lastNumber->log_error_count  + 1);
    }

}
