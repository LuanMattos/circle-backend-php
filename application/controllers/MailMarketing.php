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
            if(!empty($row['email_marketing_email']) && filter_var( $row['email_marketing_email'], FILTER_VALIDATE_EMAIL )) {
                $this->emailService->sendEmail($row);
                debug($row);
                $this->Email_marketing_model->save(
                    ['email_marketing_id' => $row['email_marketing_id'], 'email_marketing_sent' => 't']
                );
            }
        }

    }
}
