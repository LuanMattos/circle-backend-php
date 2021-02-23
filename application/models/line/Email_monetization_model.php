<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_monetization_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("email_monetization");
        $this->set_table_index("email_monetization_id");
    }
    public function getEmailLimit(){
        $limit = $this->config->item('limit_send_email_monetization_cron');
        return $this->getWhere(["date_send"=>null], "array","created_at", "ASC", $limit, NULL,false);
    }
}
