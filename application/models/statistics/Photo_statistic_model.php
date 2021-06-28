<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_statistic_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("photo_statistic");
        $this->set_table_index("photo_statistic_id");
    }
}
