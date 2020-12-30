<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Repository\Modules\Auth;
use Repository\Core;
use Modules\Account\RestoreAccount;
use Repository\Domain\User;
use Services\Domain\Auth as AuthService;
use Repository\Domain\Auth as AuthRepository;

class CAuth extends Home_Controller
{
    private $jwt;
    private $http;
    private $authService;
    private $authRepository;
    private $userRepository;

    public function __construct(){
        parent::__construct();

        $this->jwt = new Auth\Jwt();
        $this->http = new Core\Http();
        $this->authService = new AuthService\AuthService();
        $this->authRepository = new AuthRepository\AuthRepository();
        $this->userRepository = new User\UserRepository();
    }

    public function login(){
        $data = $this->http::getDataHeader();

        if( $data )
            $user = $this->authService::validaDataLogin( $data );

        $newData = [
            "user_id"                => $user->user_id,
            "user_name"              => $user->user_name,
            "user_full_name"         => $user->user_full_name,
            "user_email"             => $user->user_email,
            "description"            => $user->description,
            "address"                => $user->address,
            "user_code_verification" => $user->user_code_verification ? true : false,
            "user_device_id"         => $user->system_data_information_device_id
        ];

        $this->jwt->encode( $newData );
        $this->response( $newData );
    }

    public function register(){
        $data = $this->authService::validaDataRegister( $this->http::getDataHeader() );

        $code = new RestoreAccount\AccountService();
        $codigoVerificacao = $code->generateCode();

        $user = [
            'user_name'              => $data->userName,
            'user_email'             => $data->email,
            'user_full_name'         => $data->fullName,
            'user_password'          => password_hash( $data->password, PASSWORD_ARGON2I ),
            'user_code_verification' => $codigoVerificacao
        ];

        $this->authService->saveUserRegister( $user );
    }

    public function refreshToken(){
        $dataJwt   = $this->jwt->decode();
        $user = $this->userRepository->getUserByUserName($dataJwt->user_name);

        $data = [
            'user_id'         => $user->user_id,
            'user_avatar_url' => $user->user_avatar_url,
            'user_cover_url'  => $user->user_cover_url,
            'user_full_name'  => $user->user_full_name,
            'user_email'      => $user->user_email,
            'user_name'       => $user->user_name,
            'address'         => $user->address,
            'description'     => $user->description,
            'user_followers'  => $user->user_followers,
            'user_following'  => $user->user_following
        ];

        $this->jwt->encode( $data );
        $this->response();
    }
}
