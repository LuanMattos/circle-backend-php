<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controll_acess_external_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("_id");
        $this->set_table("controll_acess_external");
    }

}
