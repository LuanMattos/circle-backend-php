<?php
namespace Modules\Account\RestoreAccount;

use Repository\GeneralRepository;

class AccountService extends GeneralRepository  {

    public function generateCode(){
        $code = substr( uniqid(),6,10);

        return $code;
    }

}