<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Us_storage_img_cover_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("_id");
        $this->set_table("us_storage_img_cover");
    }
}
