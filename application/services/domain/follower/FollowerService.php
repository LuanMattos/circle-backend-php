<?php
namespace Services\Domain\Follower;

use Services\GeneralService;

class FollowerService extends GeneralService
{
    private static $userRepository;

    function __construct(){
        parent::__construct();
    }
}