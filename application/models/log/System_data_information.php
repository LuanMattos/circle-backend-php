<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_data_information extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("system_data_information");
        $this->set_table_index("data_information_id");
    }
}
