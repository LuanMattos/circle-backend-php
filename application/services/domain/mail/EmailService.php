<?php
namespace Services\Domain\User\EmailService;

use Services\GeneralService;
use Repository\Domain\User;

class EmailService extends GeneralService
{
    private $userRepository;
    private $mail;
    function __construct(){
        parent::__construct();
        $this->load->model('line/Email_monetization_model');
        $this->load->model('user/User_model');
        $this->userRepository = new User\UserRepository();
        $this->mail = new \Mail();
    }
    public function sendEmail( $email ){
        $emailFromMarketing = $this->config->item('email_account_marketing');
        $this->load->library('email/mail');

        $param = [];
        $param['from']              = $emailFromMarketing;
        $param['to']                = $email['email_marketing_email'];
        $param['name']              = "Circle";
        $param['assunto']           = 'Oi ' . ucfirst($email['email_marketing_description']) . ' tudo bem?';
        $data['nome']               = $email['email_marketing_description'];

        $html = $this->load->view("email/marketing", NULL,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;
        $this->mail->send( $param );
    }

    /**
    * @Cron
    **/
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
    /**
     * @Cron
     **/
    public function sendLembreteZero()
    {
        $emailFromMarketing = $this->config->item('email_account_marketing');
        $this->load->library('email/mail');
        $andWhere = 'and user_send_mail_marketing_1 = false';
        $dataEmail = $this->userRepository->getAllUsers($andWhere);

        if ( $dataEmail ) {
            foreach ( $dataEmail as $row ) {

                $param = [];
                $param['from']        = $emailFromMarketing;
                $param['to']          = $row['user_email'];
                $param['name']        = "Circle Social Sharing";
                $param['assunto']     = 'Oi ' . ucfirst( $row['user_full_name'] ) . ' tudo bem?';
                $data['nome']         = ucfirst( $row['user_full_name'] );

                $html = $this->load->view("email/invite_lembrete", $data, true);
                $param['corpo'] = '';
                $param['corpo_html'] = $html;
                if ( ENVIRONMENT === 'production' ) {
                    $data = [];
                    $data['user_id'] = $row['user_id'];
                    $data['user_send_mail_marketing_1'] = 't';

                    $this->User_model->save( $data );
                    self::Success($this->mail->send($param));
                } else {
                    self::Success("sent");
                }
            }
        }
    }
}