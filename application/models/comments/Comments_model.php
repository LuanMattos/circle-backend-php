<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("comment");
        $this->set_table_index("comment_id");
    }
    public function getCommentsByPhoto( $id, $limit = 3,$offset = 0 ){
        return $this->db
            ->order_by( 'comment_date','DESC' )
            ->select("c.*,u.*")
            ->from("comment as c")
            ->join('user u','u.user_id = c.user_id','join')
            ->limit( $limit)
            ->offset( $offset )
            ->where('photo_id = ' . $id)
            ->get()
            ->result_array();

    }

}
