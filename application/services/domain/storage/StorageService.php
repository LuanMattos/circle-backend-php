<?php
namespace Services\Domain\Storage\StorageService;
use PHPMailer\PHPMailer\Exception;
use Services\GeneralService;
use Services\Domain\Storage\Amazon;
use Repository\Domain\User;
use Repository\Domain\Photo;

class StorageService extends GeneralService{

    private $s3;
    private $s3Config;
    private $s3ConfigMovie;
    private $endpoint;
    private $endpointVideo;
    private $endpointVideoUrl;
    private $userRepository;
    private $photoRepository;

    function __construct(){
        parent::__construct();
        $this->s3 = new Amazon\S3();
        $this->s3Config = $this->config->item('bucket_name');
        $this->s3ConfigMovie = $this->config->item('bucket_name_video');
        $this->endpoint = $this->config->item('end_point');
        $this->endpointVideo = $this->config->item('end_point_video');
        $this->endpointVideoUrl = $this->config->item('end_point_video_url');
        $this->userRepository = new User\UserRepository();
        $this->photoRepository = new Photo\PhotoRepository();
    }

    public function saveImage( $user, $file, $datapost, $type = 'photo' ){
        $bucketName = $this->s3Config;
        $name_folder_user = md5($user->user_name . $user->user_id);
        $fileName = md5($file['name'] . time());

        try{
            if($this->s3->putObjectFile( $file['tmp_name'], $bucketName, $name_folder_user . '/' . $fileName, Amazon\S3::ACL_PUBLIC_READ )) {
                $url = 'https://'. $this->endpoint . '/' . $bucketName . '/' . $name_folder_user . '/' .  $fileName;
                $dataPhotoRepository = [
                    'user_name' => $user->user_name,
                    'name_folder' => $name_folder_user
                ];
                $this->userRepository->updateUserByUserName($dataPhotoRepository);
                $this->photoRepository->saveImageOrVideo($datapost, $user, $url, $type);
            }

        }catch (\S3Exception $e ){

            $result = $e->getMessage();
            debug($result);
        }
        self::Success( $result );
    }

    public function saveMovie( $user, $file, $datapost ){
        $bucketName = $this->s3ConfigMovie;
        $name_folder_user = md5($user->user_name . $user->user_id);
        $fileName = md5($file['name'] . time());

        try{
            if($this->s3->putObjectFile( $file['tmp_name'], $bucketName, $name_folder_user . '/' . $fileName, Amazon\S3::ACL_PUBLIC_READ )) {
                $url = 'https://' . $bucketName . "." .  $this->endpointVideoUrl . '/' . $name_folder_user . '/' . $fileName;
                $dataPhotoRepository = [
                    'user_name' => $user->user_name,
                    'name_folder' => $name_folder_user
                ];
                $this->userRepository->updateUserByUserName($dataPhotoRepository);
                $this->photoRepository->saveImageOrVideo($datapost, $user, $url, 'video');
            }
        }catch (\S3Exception $e ){

            $result = $e->getMessage();
            debug($result);
        }
        self::Success( $result );
    }

    public function removeImage( $uri ){
        if (strpos($uri,'/circle-photo/')){
            $bucketName = $this->s3Config;
            try{
                $lenUrlCrop = strlen('https://' . $this->endpoint . '/' . $bucketName . '/');
                $urlLen = strlen( $uri );
                $uriFormatted = substr( $uri, $lenUrlCrop, $urlLen );
                $result = $this->s3->deleteObject( $bucketName, $uriFormatted );
            }catch (\S3Exception $e ){
                $result = $e->getMessage();
            }
        }else{
            $bucketName = $this->s3ConfigMovie;
            try{
                $lenUrlCrop = strlen('https://' . $bucketName . "." .  $this->endpointVideoUrl . "/");
                $urlLen = strlen( $uri );
                $uriFormatted = substr( $uri, $lenUrlCrop, $urlLen );
                $result = $this->s3->deleteObject( $bucketName, $uriFormatted );
            }catch (\S3Exception $e ){
                $result = $e->getMessage();
            }
        }
        self::Success( $result );
    }

}

