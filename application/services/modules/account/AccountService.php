<?php
namespace Modules\Account\RestoreAccount;

use Services\GeneralService;

class AccountService extends GeneralService {

    private $user;

    public function __construct( $user )
    {
        $this->user = $user;
    }

    public function generateCode(){
        $code = substr( uniqid(),6,10);

        $data = [
            'user_code_verification' => $code
        ];

        $save = $this->db->update('user', $data, ['user_id' => $this->user->user_id], 1 );
var_dump($this->user->user_id);
        if( $save ){
            return $code;
        }else{
            http_response_code(404);
        }
    }

}