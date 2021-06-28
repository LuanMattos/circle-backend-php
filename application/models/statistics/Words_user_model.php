<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Words_user_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("words_user");
        $this->set_table_index("words_user_id");
    }
}
