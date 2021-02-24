<?php

use Services\Domain\User\EmailService;

class Dashboard extends Home_Controller
{
    private $emailService;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user/User_model');
    }

    public function index()
    {
//        SELECT * FROM square.user where user_id >= 12043 and  user_email NOT ILIKE '%@mycircle.click'

    }
}
