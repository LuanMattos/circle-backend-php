<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Us_amigos_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("_id");
        $this->set_table("us_amigos");
    }
    public function get_amigos_by_id($param){

        $full   = $this->mongodb->atos->us_amigos->find(['$or' => [
            ["codamigo"     => $param['_id']],
            ["codusuario"   => $param['_id']]
        ]]);
        $result = $full->toArray();


        foreach ($result as $row){
            if($row['codusuario'] === $param['_id']){
                    unset($row['codusuario']);
            }

        }

    }
    public function data_full_amigos( $param,$options = [],$chat = false,$count = false ){
        $this->load->model('storage/img/Us_storage_img_cover_model');
        $data = [];
        $data_amigos = reset( $this->getWhereMongoDocument(['_id'=>$param['_id']],$options ) );

        if( $count ){
            return count( $data_amigos['amigos'] );
        }

        if(isset($data_amigos['amigos'])){

            if(count($data_amigos['amigos'])){
                foreach($data_amigos['amigos'] as $row){

                    $path                   = reset($this->Us_storage_img_profile_model->getWhereMongo(['codusuario'=>reset($row['_id'])],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
                    $row['img_profile']     =  $path['server_name'] . $path['bucket'] . '/' . $path['folder_user'] . '/' . $path['name_file'];

                    $path_cover_img         = reset($this->Us_storage_img_cover_model->getWhereMongo(['codusuario'=>reset($row['_id'])],$orderby = "created_at",$direction =  -1,$limit = NULL,$offset = NULL));
                    $row['img_cover']       =  $path_cover_img['server_name'] . $path_cover_img['bucket'] . '/' . $path_cover_img['folder_user'] . '/' . $path_cover_img['name_file'];
                    $row['login']           = reset($this->Us_usuarios_model->getWhereMongo(['_id'=>reset($row['_id'])]))['login'];

                    array_push($data,$row);

                }
            }
        }
        return $data;
    }

}
