<?php
namespace Repository\Modules\Log;
use Repository\GeneralRepository;
class SystemDataInformationRepository extends GeneralRepository{
    private $dataAccess;

    function __construct(){
        parent::__construct();
        $this->load->model('log/System_data_information_model');
        $this->load->model('log/Log_access_model');
        $this->load->model('log/Location_model');
    }

    public function saveDataInformation( $user = null ){
        $sdiData = [
            'user_id'=>$user ? $user->user_id : null,
            'system_data_information_user_agent'           => isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'system_data_information_http_origin'          => isset( $_SERVER['HTTP_ORIGIN'] ) ? $_SERVER['HTTP_ORIGIN'] : '',
            'system_data_information_http_referer'         => isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '',
            'system_data_information_remote_addr'          => isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '',
            'system_data_information_host_name'            => isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : '',
            'system_data_information_ip_by_host_name'      => isset( $_SERVER['HTTP_HOST'] ) ? gethostbyname($_SERVER['HTTP_HOST']) : '',
            'system_data_information_http_x_forwarded_for' => isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '',
            'system_data_information_device_id'            => isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && $user? md5($_SERVER['HTTP_X_FORWARDED_FOR'].$user->user_id) : '',
        ];

        return $this->System_data_information_model->save( $sdiData, ['system_data_information_id','system_data_information_http_x_forwarded_for','system_data_information_device_id','system_data_information_user_agent'] );
    }

    public function saveAccessErrorUser( $sdi ){
        if( $sdi ) {
            $errorUser = [
                'error_type_id' => 7,
                'system_data_information_id' => $sdi->system_data_information_id
            ];
            $this->Log_access_model->save( $errorUser );
        }
    }

    public function saveAccessErrorPass( $user ){
        $sdi = (object)$this->saveDataInformation( $user );
        if( $sdi && $user ) {
            $errorUser = [
                'user_id'       => $user->user_id,
                'error_type_id' => 6,
                'system_data_information_id' => $sdi->system_data_information_id
            ];
            $this->Log_access_model->save( $errorUser );
            $this->saveLocation( $user->user_id );
            $this->dataAccess .= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT']: '';
            $this->compareAccessAndNotifyErrorPass( $user );
        }
    }

    private function saveLocation( $userId ){
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:set_val($_SERVER['REMOTE_ADDR']);
        $location = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
        $data = [
            'user_id'               => $userId,
            'location_coordinates'  => $location->loc,
            'location_city'         => $location->city,
            'location_state'        => $location->region,
            'location_country'      => $location->country,
            'location_organization' => $location->org,
            'location_zip_code'     => $location->postal,
            'location_time_zone'    => $location->timezone,
            'location_hostname'     => $location->hostname,
        ];
        $this->dataAccess = $location->city . "</br> - " . $location->region . "</br> - " . $location->country . "</br> - ";
        $this->Location_model->save($data);
    }

    public function compareAccessAndNotifyErrorPass( $user ){
        $dataAccess = $this->dataAccess . ' no dia ' . date('d/m/Y ') . ' às ' . date('H:i:s');

        $attemptsAccess = $this->config->item('attempts_access');
        $access = $this->Log_access_model->getCountAccessByUser( $user->user_id );

        if( ($access >= $attemptsAccess)   ){
            $this->db->update('user',['user_blocked'=>'t'],['user_id'=>$user->user_id]);
            $this->sendEmailAccess( $user, $dataAccess );
        }
    }

    public function compareAccessAndNotifyNewDevice( $user, $deviceIdToCompare ){
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:set_val($_SERVER['REMOTE_ADDR']);
        $location = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

        $dataAccess = $deviceIdToCompare->system_data_information_user_agent . " - " . $location->city . " - " . $location->region;

        if(ENVIRONMENT === 'production') {
            if ($user->user_device_id !== $deviceIdToCompare->system_data_information_device_id) {
                $this->sendEmailNewDevice($user, $dataAccess);
            }
        }
    }

    private function sendEmailNewDevice( $user, $dataAccess ){
        $emailFrom = $this->config->item('email_account');

        if(ENVIRONMENT === 'development'){
            debug('E-mail enviado!');
        }

        $mail  = new \Mail();
        $nome               = $user->user_name;
        $param = [];
        $param['from']      = $emailFrom;
        $param['to']        = $user->user_email;
        $param['name']      = "Circle";
        $param['name_to']   = $user->user_name;
        $param['assunto']   = 'Aviso de acesso à sua conta Circle!';
        $data['newDevice']  = true;
        $data['dataAccess'] = $dataAccess;
        $data['nome']       = $nome;

        $html = $this->load->view("email/confirme",$data,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;
        $mail->send( $param );

    }

    private function sendEmailAccess( $user, $dataAccess ){
        $emailFrom = $this->config->item('email_account');

        if( ENVIRONMENT === 'production' ){
            $mail  = new \Mail();
            $nome                       = $user->user_name;
            $param = [];
            $param['from']         = $emailFrom;
            $param['to']           = $user->user_email;
            $param['name']         = "Circle";
            $param['name_to']      = $user->user_name;
            $param['assunto']      = 'Aviso de acesso à sua conta Circle!';
            $data['accessAccount'] = true;
            $data['dataAccess']    = $dataAccess;
            $data['nome']          = $nome;

            $html = $this->load->view("email/confirme",$data,true);
            $param['corpo']      = '';
            $param['corpo_html'] = $html;
            $mail->send( $param );
        }
    }
}