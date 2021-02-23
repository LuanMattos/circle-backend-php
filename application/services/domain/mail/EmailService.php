<?php
namespace Services\Domain\User\EmailService;

use Services\GeneralService;

class EmailService extends GeneralService
{

    function __construct(){
        parent::__construct();
        $this->load->model('line/Email_monetization_model');
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


    public function sendEmailInviteLine()
    {
        $emailFromMarketing = $this->config->item('email_account_marketing');
        $this->load->library('email/mail');
        $dataEmail = $this->Email_monetization_model->getEmailLimit();

        if ( $dataEmail ) {
            foreach ( $dataEmail as $row ) {
                $mail = new \Mail();
                $param = [];
                $param['from']        = $emailFromMarketing;
                $param['to']          = $row['email_guest'];
                $param['name']        = "Circle Social Sharing";
                $param['assunto']     = 'Olá ' . ucfirst( $row['full_name_guest'] ) . ' tudo bem?';
                $data['nome']         = ucfirst( $row['full_name_guest'] );
                $data['nome_usuario'] = ucfirst( $row['user_full_name'] );
                $data['user_name']    = $row['user_name'];

                $html = $this->load->view("email/invite", $data, true);
                $param['corpo'] = '';
                $param['corpo_html'] = $html;
                if ( ENVIRONMENT === 'production' ) {
                    $data = [];
                    $data['email_monetization_id'] = $row['email_monetization_id'];
                    $data['date_send'] = date('Y-m-d H:m:i');

                    $this->Email_monetization_model->save( $data );
                    self::Success($mail->send($param));
                } else {
                    self::Success("sent");
                }
            }
        }
    }
}