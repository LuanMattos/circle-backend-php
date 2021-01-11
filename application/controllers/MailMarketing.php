<?php
//use Services\Domain\User\EmailService;
class MailMarketing extends Home_Controller
{
    private $emailService;

    public function __construct(){
        parent::__construct();
        $this->load->model('mail/Email_marketing_model');
//        $this->emailService = new EmailService\EmailService();
    }

    public function index(){
//        $email = $this->Email_marketing_model->getWhere(['email_marketing_sent'=>'f'], "row");

        $email = 'patrick.mattos@compasso.com.br';
        if( $email ){
            $this->sendMail( $email );
        }



    }
    public function sendMail( $email ){
//        $this->Email_marketing_model->save(['email_marketing_id'=>$email->email_marketing_id,'email_marketing_sent'=>'t']);
        $this->sendEmail( $email );
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
        $send = $mail->send( $param );
        debug($send);
    }
}
