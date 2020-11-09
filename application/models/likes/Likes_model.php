<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Likes_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("like");
        $this->set_table_index("like_id");
    }

}
