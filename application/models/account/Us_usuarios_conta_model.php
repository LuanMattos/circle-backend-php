<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Us_usuarios_conta_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("_id");
        $this->set_table("us_usuarios_conta");
    }
    public function data_conta_by_session($data_session = NULL){
        if(!$data_session || empty($data_session)){
            $this->response('error',["msg"=>"Erro ao carregar dados de sessão"]);
            exit();
        }
        $data   = $this->mongodb->atos->us_usuarios->find(['login' => $data_session['login']]);

        foreach($data as $row){
            return $row;
        }
        return false;
    }
    public function data_by_code_verification($code){

        $data   = $this->mongodb->atos->us_usuarios_conta->find(["code_verification"=>$code]);
        foreach($data as $row){
            return $row;
        }
        return false;
    }

}
