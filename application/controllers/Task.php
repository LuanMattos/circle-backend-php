<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Repository\Modules\Auth;
use Repository\Core;
use Repository\Domain\User as UserRepository;
use Repository\Domain\Monetization as MoneyRepository;
use Services\Domain\Storage\StorageService;
use Services\Domain\Monetization\MonetizationService;
use Services\Domain\User\EmailService;


class Task extends SI_Controller
{
    private $jwt;
    private $http;
    private $userRepository;
    private $emailService;
    private $s3;
    private $monetizationService;
    private $monetizationRepository;

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
        $this->monetizationRepository = new MoneyRepository\MonetizationRepository();
    }
    public function oneMinute(){
        /** 1 min **/
        $this->sendEmailInvite();
        $this->sendEmailLembreteZero();
    }

    /**
     * @Cron
    **/
    public function sendEmailInvite(){
            $this->emailService->sendEmailInviteLine();
    }
    /**
     * @Cron
    **/
    public function sendEmailLembreteZero(){
            $this->emailService->sendLembreteZero();
    }
}
