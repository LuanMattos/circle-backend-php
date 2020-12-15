<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SI_Controller extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load_helpers_default();
    }

    public  function load_helpers_default(){
        $this->load->helper(
            array('date_helper','square_helper')
        );
    }

    public function encript( $pass ){
        $argo_bc        =  password_hash( $pass, PASSWORD_DEFAULT);
        return $argo_bc;
    }

    public function decript( $pass,$datadb ){
        return password_verify( $pass,$datadb );
    }


}
