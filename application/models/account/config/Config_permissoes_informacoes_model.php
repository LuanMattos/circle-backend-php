<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_permissoes_informacoes_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("_id");
        $this->set_table("config_permissoes_informacoes");
    }


}
