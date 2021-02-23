<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monetization_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("user_monetization");
        $this->set_table_index("user_monetization_id");
    }
}
