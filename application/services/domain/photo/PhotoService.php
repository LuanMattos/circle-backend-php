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
        $this->Photo_statistic_model->save( $data );
    }


}
