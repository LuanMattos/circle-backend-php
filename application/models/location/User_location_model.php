<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_location_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("user_location");
        $this->set_table_index("user_location_id");
    }

}
