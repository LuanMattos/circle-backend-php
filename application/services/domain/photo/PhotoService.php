<?php
namespace Services\Domain\Photo;

use Services\GeneralService;
use Repository\Domain\User;
use Repository\Domain\Photo;
use Services\Domain\Storage\StorageService;

class PhotoService extends GeneralService
{
    private static $userRepository;
    private static $photoRepository;
    private static $s3;

    function __construct(){
        parent::__construct();
        static::$userRepository = new User\UserRepository();
        static::$photoRepository = new Photo\PhotoRepository();
        static::$s3 = new StorageService\StorageService();
    }

    public function deletePhotoByUser( $photoId, $userId ){
        $photo = static::$photoRepository->getPhotoByIdAndUserId( $photoId, $userId );
        static::$photoRepository->deletePhotoByUser( $photoId, $userId );
        static::$s3->removeImage( $photo->photo_url );

    }

    public function savePhotoStatistics($data){
        $this->load->model('photos/Photo_statistic_model');

        $times = $this->Photo_statistic_model->getWhere(['user_id'=>$data['user_id']]);

        if( count( $times ) ){
            $first = $data['photo_statistic_time'];
            $last = $times[ count( $times ) - 1]['photo_statistic_time'];
            if ( strlen( $first ) == 8 && strlen( $last ) == 8 ){
                $diff = strtotime( $first ) - strtotime( $last );
                $data['photo_statistic_time_diff'] = $diff;
                $this->Photo_statistic_model->save( $data, 'photo_statistic_id' );
//                $this->db->update('photo_statistic',['photo_statistic_time_diff'=>$diff],['photo_statistic_id'=>$last_id]);
            }else{
                debug($first['photo_statistic_time']);
                debug($times);
            }
        }elseif( strlen( $data['photo_statistic_time'] ) == 8 ){
            $this->Photo_statistic_model->save( $data );
        }else{
            debug('erro fdp');
        }

        if ( count( $times ) > 500 ){
            $this->Photo_statistic_model->deleteWhere(['user_id'=>$data['user_id']]);
        }

    }

}
