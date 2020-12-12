<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_access_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("log_access");
        $this->set_table_index("log_access_id");
    }
}
