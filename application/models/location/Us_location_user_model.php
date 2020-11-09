<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Us_location_user_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("_id");
        $this->set_table("us_location_user");
    }
    public function data_location_by_id($id = NULL){
        if(!$id || empty($id)){
            $this->response('error',["msg"=>"Erro ao carregar dados de sessão"]);
            exit();
        }
        $data   = $this->mongodb->atos->us_location_user->find(['_id' => $id]);

        foreach($data as $row){
            return $row;
        }
        return false;
    }


}
