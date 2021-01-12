<?php
use Services\Domain\User\EmailService;
class MailMarketing extends Home_Controller
{
    private $emailService;

    public function __construct(){
        parent::__construct();
        $this->load->model('mail/Email_marketing_model');
        $this->emailService = new EmailService\EmailService();
    }

    public function index(){
        $email = $this->Email_marketing_model->getWhere(['email_marketing_sent'=>'f'], "row");

        if( $email ){
            $this->sendMail( $email );
        }
    }
    public function sendMail( $email ){
        $this->Email_marketing_model->save(['email_marketing_id'=>$email->email_marketing_id,'email_marketing_sent'=>'t']);
        echo $email->email_marketing_mail;
        $this->emailService->sendEmail( $email->email_marketing_mail );
    }
}
