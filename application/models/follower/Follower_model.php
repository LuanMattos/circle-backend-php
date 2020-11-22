<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Follower_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("follower");
        $this->set_table_index("follower_id");
    }
//Me seguem
    public function countFollowersUserId( $id ){
        return $this->db->select("count(follower_id)")
            ->from($this->get_table())
            ->where(['user_id_to'=>$id])
            ->get()
            ->row()->count;
    }
//Estou Seguindo
    public function countFollowingUserId( $id ){
        return $this->db->select("count(follower_id)")
            ->from($this->get_table())
            ->where(['user_id_from'=>$id])
            ->get()
            ->row()->count;
    }
}
