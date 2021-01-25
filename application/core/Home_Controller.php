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
    }

    private function authRequest(){
        $this->_headers();
        $data = apache_request_headers();
        var_dump($data);
    }

    private function _headers(){
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
        if(ENVIRONMENT === 'development'){
            header('Access-Control-Allow-Origin: *');
        }else{
            header('Access-Control-Allow-Origin: ' . $this->elb_ip[0] . ',' . $this->elb_ip[1] . ',https://mycircle.click/, mycircle.click');
        }
        header('Access-Control-Allow-Headers: Origin, Authorization, Client-Security-Token, Accept-Encoding, X-Auth-Token, X-Requested-With, Content-Type, Accept, x-Access-Token');
        header('Content-type: application/json');
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


