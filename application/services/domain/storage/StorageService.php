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
    private $endpoint;
    private $userRepository;
    private $photoRepository;

    function __construct(){
        parent::__construct();
        $this->s3 = new Amazon\S3();
        $this->s3Config = $this->config->item('bucket_name');
        $this->endpoint = $this->config->item('end_point');
        $this->userRepository = new User\UserRepository();
        $this->photoRepository = new Photo\PhotoRepository();
    }

    public function saveImage( $user, $file, $datapost ){
        $bucketName = $this->s3Config;
        $name_folder_user = md5($user->user_name . $user->user_id);
        $fileName = md5($file['name'] . time());

        try{
            $this->s3->putObjectFile( $file['tmp_name'], $bucketName, $name_folder_user . '/' . $fileName, Amazon\S3::ACL_PUBLIC_READ );
            $url = 'https://'. $this->endpoint . '/' . $bucketName . '/' . $name_folder_user . '/' .  $fileName;
            $dataPhotoRepository = [
                'user_name' => $user->user_name,
                'name_folder' => $name_folder_user
            ];
            $this->userRepository->updateUserByUserName( $dataPhotoRepository );
            $this->photoRepository->saveImage( $datapost, $user, $url );

        }catch (\S3Exception $e ){
            $result = $e->getMessage();
        }
        self::Success( $result );
    }

}
