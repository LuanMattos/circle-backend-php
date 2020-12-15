<?php

namespace Services\Cor;
use Services;

class Http extends Services\GeneralService{

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

}