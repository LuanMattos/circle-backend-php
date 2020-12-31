<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photos_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("photo");
        $this->set_table_index("photo_id");
        $this->load->model('likes/Likes_model');
    }

    public function getPhotoUser( $userId, $dataUserLogged, $orderby ,$direction, $limit = 9, $offset ){

        $fields = [
            'p.photo_id',
            'p.photo_post_date',
            'p.photo_url',
            'p.photo_description',
            'p.photo_allow_comments',
            'p.photo_likes',
            'p.photo_comments',
            'p.photo_public',
            'u.user_id',
            'u.user_name',
            'u.user_full_name',
            'u.user_avatar_url',
            'u.user_cover_url'
        ];

        $photos = $this->db
            ->select( $fields )
            ->from("photo p")
            ->join("user u", "u.user_id = p.user_id","join")
            ->order_by($orderby,$direction)
            ->where("u.user_id", $userId)
            ->limit($limit)
            ->offset( $offset )
            ->get()
            ->result_array();

        if( $dataUserLogged ){
            foreach ( $photos as $key=>$item ) {
                $photos[$key]['likes'] = [];
                $photos[$key]['liked'] = $this->Likes_model->likedMe($item['photo_id'],$dataUserLogged->user_id,"row")?true:false;
            }
        }
        return $photos;
    }

}
