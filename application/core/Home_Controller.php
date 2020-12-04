<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Home_Controller extends SI_Controller {

    public function __construct(){
        parent::__construct();

        $this->authRequest();

    }

    public function authRequest(){
//        if( strstr($_SERVER['HTTP_ORIGIN'],"localhost:4200") || strstr($_SERVER['HTTP_ORIGIN'],"localhost:4200")) {
//            header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
            header('Access-Control-Allow-Origin: *');
//            header("Access-Control-Allow-Headers: Origin, Authorization, Client-Security-Token, Accept-Encoding, X-Auth-Token, X-Requested-With, Content-Type, Accept, x-Access-Token");
//            header('Content-type: application/json');

//        }else{
//            http_response_code(404);
//            exit();
//        }
    }



}
