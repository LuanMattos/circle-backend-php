<?php
namespace Services\Domain\User\EmailService;

use Services\GeneralService;

class EmailService extends GeneralService
{

    function __construct(){
        parent::__construct();
    }
    public function sendEmail( $emailTo ){
        $emailFromMarketing = $this->config->item('email_account_marketing');
        $this->load->library('email/mail');

        $mail  = new \Mail();
        $param = [];
        $param['from']              = $emailFromMarketing;
        $param['to']                = $emailTo;
        $param['name']              = "Circle";

        $html = $this->load->view("email/marketing", NULL,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;
        $mail->send( $param );

    }

}