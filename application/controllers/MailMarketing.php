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
       $this->sendMail( $email );
    }
    public function sendMail( $email ){
        if (!empty($email)) {
//        $this->Email_marketing_model->save(
//            ['email_marketing_id'=>$email->email_marketing_id,'email_marketing_sent'=>'t']
//        );
            debug($email);
            $this->emailService->sendEmail($email->email_marketing_mail);
            $this->response($email->email_marketing_mail);
        }
    }
}
