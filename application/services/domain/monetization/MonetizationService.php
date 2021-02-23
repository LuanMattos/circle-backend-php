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
    }
}