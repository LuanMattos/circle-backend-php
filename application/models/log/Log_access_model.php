<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_access_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("log_access");
        $this->set_table_index("log_access_id");
    }
    public function getCountAccessByUser( $userId ){
        return $this->db
            ->select('count(la.user_id)')
            ->from('log_access la')
            ->join('system_data_information sdi','sdi.user_id = la.user_id','left')
            ->where('la.user_id',$userId)
            ->get()
            ->row()
            ->count;

    }
}
