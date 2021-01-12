<?php
namespace Services\Domain\User\EmailService;

use Services\GeneralService;

class EmailService extends GeneralService
{

    function __construct(){
        parent::__construct();
        $this->load->model('mail/Email_marketing_model');

    }
    public function sendEmail( $email ){
        $emailFromMarketing = $this->config->item('email_account_marketing');
        $this->load->library('email/mail');

        $mail  = new \Mail();
        $param = [];
        $param['from']              = $emailFromMarketing;
        $param['to']                = $email->email_marketing_mail;
        $param['name']              = "Circle";
        $param['assunto']           = 'Circle chegou no Brasil, a mais nova rede social';

        $html = $this->load->view("email/marketing", NULL,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;
        $status = $mail->send( $param );
        $this->Email_marketing_model->save(
            ['email_marketing_id'=>$email->email_marketing_id,'email_marketing_sent'=>'t', 'status'=>$status]
        );

    }

}