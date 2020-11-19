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
        $fields = [
            'c.comment_id',
            'c.comment_date',
            'c.comment_text',
            'c.photo_id',
            'u.user_name',
            'u.user_full_name'
        ];
        return $this->db
            ->order_by( 'comment_date','DESC' )
            ->select($fields)
            ->from("comment as c")
            ->join('user u','u.user_id = c.user_id','join')
            ->limit( $limit)
            ->offset( $offset )
            ->where('c.photo_id = ' . $id)
            ->get()
            ->result_array();

    }
    public function validateCommentEdit( $id,$userName ){

        $fields = [
            'c.comment_id',
            'c.comment_date',
            'c.comment_text',
            'c.photo_id',
            'u.user_name',
            'u.user_full_name'
        ];
        return $this->db
            ->select( $fields )
            ->from("comment as c")
            ->join('user u','u.user_id = c.user_id','join')
            ->where(  'c.comment_id = ' . $id )
            ->like(  'u.user_name' , $userName )
            ->get()
            ->first_row();
    }

}
