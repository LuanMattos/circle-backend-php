<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provider_sms_model extends CI_Model {


    public function __construct(){
        parent::__construct();
        $this->set_table_index("codigo");
        $this->set_table("provider_sms");
    }



}
