<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Home_Controller extends SI_Controller {
    private $prod;
    private $devBack;
    private $devFront;
    private $headers;

    public function __construct(){
        parent::__construct();
        $this->setConfigs();
        $this->authRequest();
    }

    private function authRequest(){
        $this->_headers();
        if( ENVIRONMENT == 'production' ){
            if( (
                hostOrigin($this->prod)
                )
                &&
                compareVarsHttp('HTTPS',"on")) {
               $this->_headers();
            }else{
                http_response_code(404);
                exit();
            }
        }else if(ENVIRONMENT == 'development'
            &&  (hostOrigin($this->devFront) || hostOrigin($this->devBack))){
            $this->_headers();
        }
    }

    private function _headers(){
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, Authorization, Client-Security-Token, Accept-Encoding, X-Auth-Token, X-Requested-With, Content-Type, Accept, x-Access-Token');
        header('Content-type: application/json');
    }

    private function setConfigs(){
        $this->config->load('config');
        $this->prod = $this->config->item('origin_prod');
        $this->devBack = $this->config->item('origin_dev_back');
        $this->devFront = $this->config->item('origin_dev_front');
        $this->headers = $this->config->item('headers');
    }



}
