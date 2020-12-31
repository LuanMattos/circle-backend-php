<?php
namespace Repository\Domain\Photo;
use Repository\GeneralRepository;

class PhotoRepository extends GeneralRepository{
    function __construct(){
        parent::__construct();
        $this->load->model('photos/Photos_model');
        $this->load->model('follower/Follower_model');
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
        self::Success($url);

    }

    public function getPhotoToExplorer( $offset, $user ){

        $fields = [
            'p.photo_id',
            'p.photo_post_date',
            'p.photo_url',
            'p.photo_description',
            'p.photo_allow_comments',
            'p.photo_likes',
            'p.photo_comments',
            'p.photo_public',
            'u.user_name',
            'u.user_full_name',
            'u.user_avatar_url',
            'u.user_cover_url'
        ];

        $photos = $this->db
                       ->select( $fields )
                       ->from("photo p")
                       ->join("user u", "u.user_id = p.user_id","join")
                       ->order_by("p.photo_post_date","DESC")
                       ->limit(10)
                       ->offset( $offset )
                       ->get()
                       ->result_array();

        if( $user ){
            foreach ( $photos as $key=>$item ) {
//                Será feito separado, ao clicar no número de likes
                $photos[$key]['likes'] = [];
                $photos[$key]['liked'] = $this->Likes_model->likedMe($item['photo_id'],$user->user_id,"row")?true:false;
            }
            return $photos;
        }
        return [];
    }

    public function getPhotoTimeline( $offset, $user ){

        $fields = [
            'p.photo_id',
            'p.photo_post_date',
            'p.photo_url',
            'p.photo_description',
            'p.photo_allow_comments',
            'p.photo_likes',
            'p.photo_comments',
            'p.photo_public',
            'u.user_name',
            'u.user_full_name',
            'u.user_avatar_url',
            'u.user_cover_url'
        ];

        $circle = [];
        $following = $this->Follower_model->getWhere(['user_id_from' => $user->user_id], "array", 'follower_date', 'DESC', "10", $offset);

        foreach( $following as $row ){
            array_push($circle, $row['user_id_to']);
        }

        if( $circle ) {
            $photos = $this->db->select($fields)
                ->from('photo p')
                ->join('user u', 'u.user_id = p.user_id', 'left')
                ->where_in('p.user_id', $circle)
                ->get()
                ->result_array();

            foreach ( $photos as $key=>$item ) {
                $photos[$key]['likes'] = [];
                $photos[$key]['liked'] = $this->Likes_model->likedMe($item['photo_id'],$user->user_id,"row")?true:false;
            }

            return $photos;
        }
        return [];

    }

    public function getPhotoByIdAndUserId( $id, $userId ){
        return $this->Photos_model->getWhere(['photo_id' => $id,'user_id'=>$userId ], "row");
    }
}