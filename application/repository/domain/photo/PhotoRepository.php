<?php
namespace Repository\Domain\Photo;
use Repository\GeneralRepository;

class PhotoRepository extends GeneralRepository{
    function __construct(){
        parent::__construct();
        $this->load->model('photos/Photos_model');
    }

    public function deletePhotoByUser( $photoId, $userId ){
        $this->Photos_model->deletewhere(['photo_id'=>$photoId,'user_id'=>$userId]);
    }
}