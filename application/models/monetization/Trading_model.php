<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trading_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("trading");
        $this->set_table_index("trading_id");
    }
}
