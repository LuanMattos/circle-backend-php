<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_log_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("error_log");
        $this->set_table_index("error_log_id");
    }
}
