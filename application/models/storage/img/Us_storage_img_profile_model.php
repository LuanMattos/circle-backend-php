<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Us_storage_img_profile_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table_index("codigo");
        $this->set_table("us_storage_img_profile");
    }
    public function get_img_profile($data = NULL){
        $us_storage_img_profile = $this->mongodb->atos->us_storage_img_profile;

        $options            = ["sort" => ["created_at" => 1]];
        $path_profile_img   = $us_storage_img_profile->find(['codusuario'=>$data['codigo']],$options);
        $path               = [];

        foreach($path_profile_img as $row){
            $path    =  $row['server_name'] . $row['bucket'] . '/' . $row['folder_user'] . '/' . $row['name_file'];

        }
        return $path;
    }
}
