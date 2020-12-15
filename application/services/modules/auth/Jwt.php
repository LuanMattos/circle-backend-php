<?php

namespace Services\Modules\Auth;
use Firebase\JWT as LibJwt;

use PHPMailer\PHPMailer\Exception;
use Services;
use \DateTime;

class Jwt extends Services\GeneralService {
    private $jwtInstance;
    private $private_key_jwt;
    private $public_key_jwt;
    private $expireToken;

    public  function __construct(){
        parent::__construct();
        $this->jwtInstance = new LibJwt\JWT();
        $this->public_key_jwt = $this->config->item('public_key_jwt');
        $this->private_key_jwt = $this->config->item('private_key_jwt');
        $this->jwtInstance::$leeway = $this->config->item('leeway_token');
        $this->expireToken = $this->config->item('expire_token');
    }

    public function decode(){
        $data = apache_request_headers();
        $token = $data['x-access-token'];
        // usar chave publica do certificado digital SSL - AMAZON
        try{
            return $this->jwtInstance::decode( $token, $this->public_key_jwt, ['HS256'] );
        }catch ( Exception $e ){
            self::Success($e->getMessage(),'error');
        }
    }

    public function encode( $jwt ){

        $tokenId    = base64_encode( md5(random_bytes (32) . time() . $jwt['user_id'] ) ); //Não pode se repetir
        $issuedAt   = time();
        $notBefore  = $issuedAt + 2;
        $expire     = $notBefore + $this->expireToken;
        $serverName = $_SERVER['SERVER_NAME'];

        $data = [
            'iat'  => $issuedAt,
            'jti'  => $tokenId,
            'iss'  => $serverName,
            'nbf'  => $notBefore,
            'exp'  => $expire,
            'data' => $jwt
        ];
        // usar chave privada do certificado digital SSL - AMAZON
        $dados = $this->jwtInstance::encode( $data, $this->public_key_jwt,'HS256',null );
        self::setHeaders( $dados,'x-access-token' );

    }

}
