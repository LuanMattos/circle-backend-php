<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("user");
        $this->set_table_index("user_id");
    }
    public function searchUser( $name,$offset = null ){
        return $this->db
            ->select("user_full_name,user_name,address,user_avatar_url")
            ->from("user as u")
            ->limit( 10)
            ->offset( $offset )
            ->like('u.user_full_name',"$name",'both')
            ->or_like('u.user_name',"$name",'both')
            ->get()
            ->result_array();
    }
    public function userExistsEmail($email){
        return $this->db
            ->select("count(user_id)")
            ->from("user as u")
            ->limit( 1)
            ->where('u.user_email',"$email")
            ->get()
            ->row()
            ->count;
    }
    public function userExistsUserName($userName  ){
        return $this->db
            ->select("count(user_id)")
            ->from("user as u")
            ->limit( 1)
            ->where('u.user_name',"$userName")
            ->get()
            ->row()
            ->count;
    }

}
