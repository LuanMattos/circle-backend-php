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

        $this->db->update('user', $data, ['user_id' => $this->user->user_id], 1 );
        return $code;
    }

}