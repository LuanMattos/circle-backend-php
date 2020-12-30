<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Services\\Domain\\User\\UserService\\' => array($baseDir . '/services/domain/user'),
    'Services\\Domain\\Storage\\StorageService\\' => array($baseDir . '/services/domain/storage'),
    'Services\\Domain\\Storage\\Amazon\\' => array($baseDir . '/services/domain/storage/amazon'),
    'Services\\Domain\\Photo\\' => array($baseDir . '/services/domain/photo'),
    'Services\\Domain\\Follower\\' => array($baseDir . '/services/domain/follower'),
    'Services\\Domain\\Auth\\' => array($baseDir . '/services/domain/auth'),
    'Services\\' => array($baseDir . '/services'),
    'Repository\\Modules\\Log\\' => array($baseDir . '/repository/modules/log'),
    'Repository\\Modules\\Auth\\' => array($baseDir . '/repository/modules/auth'),
    'Repository\\Domain\\User\\' => array($baseDir . '/repository/domain/user'),
    'Repository\\Domain\\Photo\\' => array($baseDir . '/repository/domain/photo'),
    'Repository\\Domain\\Follower\\' => array($baseDir . '/repository/domain/follower'),
    'Repository\\Domain\\Auth\\' => array($baseDir . '/repository/domain/auth'),
    'Repository\\Core\\' => array($baseDir . '/repository/core'),
    'Repository\\' => array($baseDir . '/repository'),
    'PHPMailer\\PHPMailer\\' => array($baseDir . '/libraries/email/vendor/phpmailer/phpmailer/src'),
    'Modules\\Storage\\CreateFolderUserRepository\\' => array($baseDir . '/repository/modules/storage'),
    'Modules\\Account\\RestoreAccount\\' => array($baseDir . '/repository/modules/account'),
    'Firebase\\JWT\\' => array($baseDir . '/repository/tools/firebase/php-jwt/src', $vendorDir . '/firebase/php-jwt/src'),
);
