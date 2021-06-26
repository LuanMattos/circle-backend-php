<?php

namespace Services\Domain\Photo;

use phpDocumentor\Reflection\Types\Boolean;
use SebastianBergmann\Comparator\DateTimeComparator;
use Services\GeneralService;
use Repository\Domain\User;
use Repository\Domain\Photo;
use Services\Domain\Storage\StorageService;

class PhotoService extends GeneralService
{
    private static $userRepository;
    private static $photoRepository;
    private static $s3;

    function __construct()
    {
        parent::__construct();
        static::$userRepository = new User\UserRepository();
        static::$photoRepository = new Photo\PhotoRepository();
        static::$s3 = new StorageService\StorageService();
        $this->load->model('photos/Photo_statistic_model');

    }

    public function deletePhotoByUser($photoId, $userId)
    {
        $photo = static::$photoRepository->getPhotoByIdAndUserId($photoId, $userId);
        static::$photoRepository->deletePhotoByUser($photoId, $userId);
        static::$s3->removeImage($photo->photo_url);

    }

    public function updateLastItemWithTime( $data ){
        if( $data['user_id'] ){
            $this->Photo_statistic_model->save( $data );
        }
    }
    public function sendStatistic(){
        $username = "admin";
        $password = "admin";
        $headers = [
            'Content-Type: application/json',
//            'Authorization: Basic '. base64_encode("$username:$username")
        ];
        $url = $this->config->item('drf') . "users";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        debug($output);

        curl_close($ch);
    }



}
