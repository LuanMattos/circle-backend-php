<?php

namespace Repository\Core;
use Repository;

class Http extends Repository\GeneralRepository{

    public  function __construct(){
        parent::__construct();
    }

    public static function getDataHeader(){

        $data = file_get_contents('php://input');
        $data ? $header = json_decode( $data ) : $header = false;

        return $header;
    }

    public function getDataUrl( $segment )
    {
        $uri  = $this->uri->slash_segment( $segment );
        return str_replace( ['/','?','´'],'',$uri );
    }
    public function RunCurlPostServices($url,$config)
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERPWD, "{$config['username']}:{$config['password']}");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:   application/json"
        ));
        if( curl_errno( $ch ) ){

            throw new Exception( curl_error( $ch ) );
        }
        return curl_exec( $ch );
    }

}