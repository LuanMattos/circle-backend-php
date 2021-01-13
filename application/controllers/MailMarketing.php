<?php

use Services\Domain\User\EmailService;

class MailMarketing extends Home_Controller
{
    private $emailService;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mail/Email_marketing_model');
        $this->emailService = new EmailService\EmailService();
    }

    public function index()
    {
        $email = $this->Email_marketing_model->getWhere(['email_marketing_sent' => 'f'], "array", NULL, "DESC", 5, NULL);
        foreach ($email as $row) {
            $parts = explode('@', $row['email_marketing_email']);
            $domain = array_pop($parts);
            $allowed = [
                'gmail.com',
                'hotmail.com',
                'yahoo.com',
                'yahoo.com.br',
                'outlook.com',
            ];
            if(filter_var( $row['email_marketing_email'], FILTER_VALIDATE_EMAIL ) && in_array($domain, $allowed)) {
                $this->emailService->sendEmail($row);
                $this->Email_marketing_model->save(
                    ['email_marketing_id' => $row['email_marketing_id'], 'email_marketing_sent' => 't']
                );
            }else{
                $this->Email_marketing_model->save(
                    ['email_marketing_id' => $row['email_marketing_id'], 'email_marketing_sent' => 't', 'status'=>'Invalid email']
                );
            }

        }

    }
}
