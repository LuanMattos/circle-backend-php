<?php

namespace Services\Domain\Monetization\MonetizationService;

use Services\GeneralService;
use Repository\Domain\User;

class MonetizationService extends GeneralService
{
    private static $userRepository;

    function __construct()
    {
        parent::__construct();
        static::$userRepository = new User\UserRepository();
        $this->load->model('line/Email_monetization_model');
    }
    public function saveEmailInvite( $full_name, $email, $jwt ){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            self::Success("Invalid Email!");
            exit();
        }
        $data = [];
        $data['user_full_name'] = $jwt->user_full_name;
        $data['user_name'] = $jwt->user_name;
        $data['user_id'] = $jwt->user_id;
        $data['full_name_guest'] = ucfirst( $full_name );
        $data['email_guest'] = $email;

        $valid = $this->Email_monetization_model->getWhere(['email_guest'=>$email], "row");
        if($valid){
            self::Success("Este usuário já foi convidado por algúem");
        }

        $this->Email_monetization_model->save($data);
        self::Success("success");
    }
}