<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Follower_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("follower");
        $this->set_table_index("follower_id");
    }
}
