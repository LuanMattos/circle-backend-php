<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1cca8763c9fc2af40fe209ed4f2a2657
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Services\\Domain\\User\\UserService\\' => 33,
            'Services\\Domain\\User\\EmailService\\' => 34,
            'Services\\Domain\\Storage\\StorageService\\' => 39,
            'Services\\Domain\\Storage\\Amazon\\' => 31,
            'Services\\Domain\\Photo\\' => 22,
            'Services\\Domain\\Monetization\\MonetizationService\\' => 49,
            'Services\\Domain\\Follower\\' => 25,
            'Services\\Domain\\Auth\\' => 21,
            'Services\\' => 9,
        ),
        'R' => 
        array (
            'Repository\\Modules\\Log\\' => 23,
            'Repository\\Modules\\Auth\\' => 24,
            'Repository\\Domain\\User\\' => 23,
            'Repository\\Domain\\Photo\\' => 24,
            'Repository\\Domain\\Monetization\\' => 31,
            'Repository\\Domain\\Follower\\' => 27,
            'Repository\\Domain\\Auth\\' => 23,
            'Repository\\Core\\' => 16,
            'Repository\\' => 11,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' => 
        array (
            'Modules\\Twitter\\TwitterAPIExchange\\' => 35,
            'Modules\\Storage\\CreateFolderUserRepository\\' => 43,
            'Modules\\Account\\RestoreAccount\\' => 31,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Services\\Domain\\User\\UserService\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/domain/user',
        ),
        'Services\\Domain\\User\\EmailService\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/domain/mail',
        ),
        'Services\\Domain\\Storage\\StorageService\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/domain/storage',
        ),
        'Services\\Domain\\Storage\\Amazon\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/domain/storage/amazon',
        ),
        'Services\\Domain\\Photo\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/domain/photo',
        ),
        'Services\\Domain\\Monetization\\MonetizationService\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/domain/monetization',
        ),
        'Services\\Domain\\Follower\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/domain/follower',
        ),
        'Services\\Domain\\Auth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/domain/auth',
        ),
        'Services\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services',
        ),
        'Repository\\Modules\\Log\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/modules/log',
        ),
        'Repository\\Modules\\Auth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/modules/auth',
        ),
        'Repository\\Domain\\User\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/domain/user',
        ),
        'Repository\\Domain\\Photo\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/domain/photo',
        ),
        'Repository\\Domain\\Monetization\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/domain/monetization',
        ),
        'Repository\\Domain\\Follower\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/domain/follower',
        ),
        'Repository\\Domain\\Auth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/domain/auth',
        ),
        'Repository\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/core',
        ),
        'Repository\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/../..' . '/libraries/email/vendor/phpmailer/phpmailer/src',
        ),
        'Modules\\Twitter\\TwitterAPIExchange\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/modules/twiter',
        ),
        'Modules\\Storage\\CreateFolderUserRepository\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/modules/storage',
        ),
        'Modules\\Account\\RestoreAccount\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/modules/account',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repository/tools/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1cca8763c9fc2af40fe209ed4f2a2657::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1cca8763c9fc2af40fe209ed4f2a2657::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
