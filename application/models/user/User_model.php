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
            ->order_by( 'user_full_name','DESC' )
            ->select("user_full_name,user_name,address")
            ->from("user as u")
            ->limit( 10)
            ->offset( $offset )
            ->like('u.user_full_name',"$name",'both')
            ->or_like('u.user_name',"$name",'both')
            ->get()
            ->result_array();
    }

}
