<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_marketing_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("email_marketing");
        $this->set_table_index("email_marketing_id");
    }

}
