<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("location");
        $this->set_table_index("location_id");
    }

}
