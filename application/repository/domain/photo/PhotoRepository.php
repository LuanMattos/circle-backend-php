<?php
namespace Repository\Domain\Photo;
use Repository\GeneralRepository;

class PhotoRepository extends GeneralRepository{
    function __construct(){
        parent::__construct();
        $this->load->model('photos/Photos_model');
        $this->load->model('user/User_model');
    }

    public function deletePhotoByUser( $photoId, $userId ){
        $this->Photos_model->deletewhere(['photo_id'=>$photoId,'user_id'=>$userId]);
    }

    public function updatePhoto( $photoId, $photoDescription, $userId ){
       $this->db->update('photo',['photo_description'=>$photoDescription],['photo_id'=>$photoId,'user_id'=>$userId]);
    }

    public function saveImage( $post, $user, $url, $type = 'photo'){
        if( $type === 'photo' && $post ):

            $data = [
                'user_id' => $user->user_id,
                'photo_post_date' => date('Y-m-d H:i:s'),
                'photo_url' => $url,
                'photo_description' => $post->description,
                'photo_allow_comments' => $post->allowComments === 'false'?'0':'1',
                'photo_public' => $post->public === 'true'?'1':'0',
                'photo_likes' => 0,
            ];
            $this->Photos_model->save( $data );

        elseif ( $type === 'cover' ||  $type === 'avatar'):
            $data = [
                'user_id'=>$user->user_id,
                'user_' . $type . '_url' => $url,
            ];
            $this->User_model->save( $data );

        else:
            self::Success('Error on upload type','error');
        endif;
    }
}