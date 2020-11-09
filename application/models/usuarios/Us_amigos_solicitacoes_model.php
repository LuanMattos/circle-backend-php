<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Us_amigos_solicitacoes_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("_id");
        $this->set_table("us_amigos_solicitacoes");
    }
    public function deleta_amizade($codusuario,$codamigo){
        $mongobulkwrite         = $this->mongobulkwrite;
        $mongobulkwrite->delete(["codusuario"=>$codamigo,'codamigo'=>$codusuario], ['limit' => 1]);
        $this->mongomanager->executeBulkWrite('atos.' . $this->get_table(),$mongobulkwrite);
    }
    public function data_solicitacoes_by_id($param){
        $query = $this->mongodb->atos->us_amigos_solicitacoes->find(['codamigo'=>$param['codamigo'],'codusuario'=>$param['codusuario']]);
        return $query->toArray();
    }
}
