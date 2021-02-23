<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Repository\Modules\Auth;
use Repository\Core;
use Repository\Domain\User as UserRepository;
use Services\Domain\Storage\StorageService;
use Services\Domain\Monetization\MonetizationService;
use Services\Domain\User\EmailService;


class Monetization extends Home_Controller
{
    private $jwt;
    private $http;
    private $userRepository;
    private $emailService;
    private $s3;

    public function __construct(){
        parent::__construct();
        $this->load->model("user/User_model");
        $this->load->library('email/mail');

        $this->jwt = new Auth\Jwt();
        $this->http = new Core\Http();
        $this->userRepository = new UserRepository\UserRepository();
        $this->emailService = new EmailService\EmailService();
        $this->s3 = new StorageService\StorageService();
    }
    public function index(){
        $data['nome']               = ucfirst("jao");
        $data['nome_usuario']       = ucfirst('cachorro fdp');
        $data['user_name']       = ucfirst('userName');

        $this->load->view("email/invite");
    }

    public function sendEmailInvite(){
        $dataJwt   = $this->jwt->decode();
        $data = (object)$this->http::getDataHeader();
        if( isset($data->data->fullName) && isset($data->data->email) ) {
            $full_name = $data->data->fullName;
            $email = $data->data->email;
            $this->emailService->sendEmailInvite($full_name, $email, $dataJwt->user_full_name, $dataJwt->user_name);
        }
    }

}
