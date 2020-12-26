<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1cca8763c9fc2af40fe209ed4f2a2657
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Services\\Domain\\User\\UserService\\' => 33,
            'Services\\Domain\\Storage\\StorageService\\' => 39,
            'Services\\Domain\\Storage\\Amazon\\' => 31,
            'Services\\Domain\\Photo\\' => 22,
            'Services\\Domain\\Auth\\' => 21,
            'Services\\' => 9,
        ),
        'R' => 
        array (
            'Repository\\Modules\\Log\\' => 23,
            'Repository\\Modules\\Auth\\' => 24,
            'Repository\\Domain\\User\\' => 23,
            'Repository\\Domain\\Photo\\' => 24,
            'Repository\\Core\\' => 16,
            'Repository\\' => 11,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' => 
        array (
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
            1 => __DIR__ . '/..' . '/firebase/php-jwt/src',
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
