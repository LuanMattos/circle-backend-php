<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_twitter_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("user_twitter");
        $this->set_table_index("user_id");
    }

}
