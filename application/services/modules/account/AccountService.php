<?php
namespace Modules\Account\RestoreAccount;

use Services\GeneralService;

class AccountService extends GeneralService {

    public function generateCode(){
        $code = substr( uniqid(),6,10);

        return $code;
    }

}