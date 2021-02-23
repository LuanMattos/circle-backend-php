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
    private $monetizationService;

    public function __construct(){
        parent::__construct();
        $this->load->model("user/User_model");
        $this->load->library('email/mail');

        $this->jwt = new Auth\Jwt();
        $this->http = new Core\Http();
        $this->userRepository = new UserRepository\UserRepository();
        $this->emailService = new EmailService\EmailService();
        $this->s3 = new StorageService\StorageService();
        $this->monetizationService = new MonetizationService\MonetizationService();
    }

    public function sendEmailInvite(){
            $this->emailService->sendEmailInviteLine();
    }
    public function saveEmailInvite(){
        $dataJwt   = $this->jwt->decode();
        $data = (object)$this->http::getDataHeader();
        if( isset($data->data->fullName) && isset($data->data->email) ) {
            $full_name = $data->data->fullName;
            $email = $data->data->email;
            $this->monetizationService->saveEmailInvite($full_name, $email, $dataJwt);
        }
    }
    public function getDataDashBoard(){
        $dataJwt   = (object)$this->jwt->decode();
    }

}
