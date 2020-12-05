<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SI_Controller extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load_helpers_default();
    }

    public function setHeaders( $data ,$name ){
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, $name");
        header("Access-Control-Expose-Headers: $name");
        header("$name: $data data");
    }

    /** Transeferir para classe especifica de JWT (usar bibliotecas para isso) **/
    public function generateJWT( $data ){
        $header             = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload            = json_encode( $data );
        $base64UrlHeader    = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        $base64UrlPayload   = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature          = hash ("SHA256", 'teste');
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        return $jwt;
    }
    public function decodeJWT( $data ){
        $data = $this->jsonToArray( $data );
        return $data;
    }
    public function dataUserJwt( $index ){
        $data = apache_request_headers();
        return $this->jsonToArray( $data[$index],true );
    }
    private function jsonToArray( $json,$user = false ){
        $explode = explode( '.' , $json );
        $data = [];
        foreach( $explode as $key => $row ){
            $newRow = str_replace( ['+', '/', '='], ['-', '_', ''], base64_decode( $row ) );
            array_push( $data,json_decode( $newRow ) );
        }
        return  !$user ? $data : $data[1];
    }

//    -----------------------------the end jwt-----------------------------------


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

    public function getDataUrl( $segment )
    {
        $uri  = $this->uri->slash_segment( $segment );
        return str_replace( ['/','?','´'],'',$uri );
    }

    public function getDataHeader(){

        $data = file_get_contents('php://input');
        $data ? $header = json_decode( $data ) : $header = false;

        return $header;
    }


}
