<?php
namespace Services\Domain\User\EmailService;

use Services\GeneralService;

class EmailService extends GeneralService
{

    function __construct(){
        parent::__construct();

    }
    public function sendEmail( $email ){
        $emailFromMarketing = $this->config->item('email_account_marketing');
        $this->load->library('email/mail');


        $mail  = new \Mail();
        $param = [];
        $param['from']              = $emailFromMarketing;
        $param['to']                = $email['email_marketing_email'];
        $param['name']              = "Circle";
        $param['assunto']           = 'Oi ' . ucfirst($email['email_marketing_description']) . ' tudo bem?';
        $data['nome']               = $email['email_marketing_description'];

        $html = $this->load->view("email/marketing", NULL,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;
        $mail->send( $param );


    }

}