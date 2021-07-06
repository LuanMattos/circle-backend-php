<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Repository\Modules\Auth;
use Repository\Core;
use Repository\Domain\User as UserRepository;
use Repository\Domain\Monetization as MoneyRepository;
use Services\Domain\Storage\StorageService;
use Services\Domain\Monetization\MonetizationService;
use Services\Domain\User\EmailService;
use Services\Domain\Photo as PhotoService;
use Repository\Domain\Photo;


class Task extends SI_Controller
{
    private $jwt;
    private $http;
    private $userRepository;
    private $emailService;
    private $s3;
    private $monetizationService;
    private $monetizationRepository;
    private $photoRepository;

    public function __construct(){
//        if(ENVIRONMENT !== 'production'){
//            exit('Access Denied');
//        }
        parent::__construct();
        $this->load->model("user/User_model");
        $this->load->library('email/mail');

        $this->jwt = new Auth\Jwt();
        $this->http = new Core\Http();
        $this->userRepository = new UserRepository\UserRepository();
        $this->emailService = new EmailService\EmailService();
        $this->s3 = new StorageService\StorageService();
        $this->monetizationService = new MonetizationService\MonetizationService();
        $this->monetizationRepository = new MoneyRepository\MonetizationRepository();
        $this->photoService = new PhotoService\PhotoService();
        $this->photoRepository = new Photo\PhotoRepository();
    }
    /**
     * @Cron que roda de um em um minuto
     **/
    public function oneMinute(){
        $username = $_GET['u'];
        $this->saveAndDownlaod($username);
    }
    public function miningInstagram($username){
        $curl = curl_init();
        $param = $username;

        curl_setopt_array( $curl, [
            CURLOPT_URL => "https://instagram40.p.rapidapi.com/account-feed?username=$param",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: instagram40.p.rapidapi.com",
                "x-rapidapi-key: 2e0c8f11c0msh1a602957b9ea244p19bcd7jsn7cdf72bafd2f"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            debug($err);
        } else {
            $json = json_decode( $response );
            return  $json;
        }
    }
    public function saveAndDownlaod($username){
        $items = $this->miningInstagram($username);
        foreach ( $items as $key=>$row ){
            $node = $row->node;
            $photo = $node->is_video?$node->video_url:$node->display_url;
            $usuario = $node->owner->username;
            $photo_description = $node->edge_media_to_caption->edges[0]->node->text;


            $extension = $node->is_video?'.mp4':'.jpg';
            $name_file = md5( $photo . date(now()) ). $extension;
            $photo_url = "https://circle-photo.s3.sa-east-1.amazonaws.com/photos_videos_instagram/" . $name_file;

            $photos['photo_url'] = $photo_url;
            $photos['photo_description'] = $photo_description;


            $path_temp_name = 'storage/instagram/' . $name_file;
            $this->downloadFile( $photo, $path_temp_name );

            if( $key == 0 ) {
                $user['user_name'] = $usuario;
                $user['user_password'] = '$argon2i$v=19$m=65536,t=4,p=1$LjVHbzhBTzVLY0QzTDA2UQ$mHygzGkjxdpvP6wWSjRz8/idQ9bZ7V11xvpy+uE/VAk';
                $user['user_email'] = $usuario . rand(0, 1000000) . '@mycircle.click';
                $user['user_full_name'] = $usuario;
                $user['user_avatar_url'] = $photo_url;
                $this->userRepository->saveUserRegister( $user );
            }
//            $type = $node->is_video?'video':'photo';
            $user = $this->userRepository->getUserByUserName( $usuario );
            $photos['user_id'] = $user->user_id;
            $photos['photo_post_date'] = date('Y-m-d H:i:s');

//            $myfiles = array_diff(scandir($path_temp_name), array('.', '..'));
//            unlink($path_temp_name);

            $this->photoRepository->savePhoto( $photos );
        }
    }
    private function downloadFile($url, $path)
    {
        $newfname = $path;
        $file = fopen ($url, 'rb');
        if ($file) {
            $newf = fopen ($newfname, 'wb');
            if ($newf) {
                while(!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }
        if ($file) {
            fclose($file);
        }
        if ($newf) {
            fclose($newf);
        }
    }


    public function sendEmailInvite(){
            $this->emailService->sendEmailInviteLine();
    }
    /**
     * @Cron
    **/
    public function sendEmailLembreteZero(){
            $this->emailService->sendLembreteZero();
    }
}
