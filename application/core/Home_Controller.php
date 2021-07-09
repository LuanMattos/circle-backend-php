<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_Controller extends SI_Controller {
    private $origin_prod;
    private $devBack;
    private $devFront;
    private $headers;
    private $elb_ip;
    private $ipIgnore;

    public function __construct(){
        parent::__construct();
        $this->setConfigs();
        $this->authRequest();
//        debug(password_hash( "admin123", PASSWORD_ARGON2I ));
    }

    private function authRequest(){
        $this->_headers();
    }

    private function _headers(){
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
        if(ENVIRONMENT === 'development'){
            header('Access-Control-Allow-Origin: *');
        }else{
            $http_origin = $_SERVER['HTTP_ORIGIN'];
            debug($http_origin);

            if (
                ($http_origin == $this->elb_ip[0] || $http_origin == "https://mycircle.click" || $http_origin == "127.0.0.1")
            )
            {
                header("Access-Control-Allow-Origin: $http_origin");
            }else{
                $this->response('Access Denied ' . $_SERVER['HTTP_ORIGIN'],'error');
                set_status_header(404);
                exit();
            }
        }

        header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type');
        header('Access-Control-Allow-Headers: Origin, Authorization, Client-Security-Token, Accept-Encoding, X-Auth-Token, X-Requested-With, Content-Type, Accept, x-Access-Token');
        header('Content-Type: application/json, charset=utf-8');
    }

    private function setConfigs(){
        $this->config->load('config');
        $this->origin_prod = $this->config->item('origin_prod');
        $this->elb_ip = $this->config->item('elb_ip');
        $this->devBack = $this->config->item('origin_dev_back');
        $this->devFront = $this->config->item('origin_dev_front');
        $this->headers = $this->config->item('headers');
        $this->ipIgnore = $this->config->item('ip_ignore');
    }
    public function logHome(){
        $this->load->model('log/System_data_information_model');
        $this->load->model('location/Location_model');

        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:set_val($_SERVER['REMOTE_ADDR']);

        if( !in_array( $ip,$this->ipIgnore ) ) {

            $data = [
                'system_data_information_local_storage' => '',
                'system_data_information_cookies' => '',
                'system_data_information_user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
                'system_data_information_http_origin' => isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '',
                'system_data_information_http_referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
                'system_data_information_remote_addr' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
                'system_data_information_host_name' => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '',
                'system_data_information_ip_by_host_name' => isset($_SERVER['HTTP_HOST']) ? gethostbyname($_SERVER['HTTP_HOST']) : '',
                'system_data_information_http_x_forwarded_for' => isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '',
            ];
            $this->System_data_information_model->save($data);

            $location = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

            $data = [
                'location_coordinates' => $location->loc,
                'location_city' => $location->city,
                'location_state' => $location->region,
                'location_country' => $location->country,
                'location_organization' => $location->org,
                'location_zip_code' => $location->postal,
                'location_time_zone' => $location->timezone,
                'location_hostname' => $location->hostname,
            ];

            $this->Location_model->save($data);
        }

    }



}


