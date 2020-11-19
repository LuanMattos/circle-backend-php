<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Likes_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("like");
        $this->set_table_index("like_id");
    }
    public function countLikesPhotoId( $id ){
        return $this->db->select("count(photo_id)")
            ->from($this->get_table())
            ->where(['photo_id'=>$id])
            ->get()
            ->row()->count;
    }
    public function likedMe( $id,$userId ){
        return $this->db->select("photo_id")
            ->from('like l')
            ->where(['l.photo_id'=>$id,'l.user_id'=>$userId])
            ->get()
            ->result_array();
    }

}
