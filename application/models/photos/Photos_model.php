<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photos_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("photo");
        $this->set_table_index("photo_id");
    }

}
