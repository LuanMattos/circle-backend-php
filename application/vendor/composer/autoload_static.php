<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1cca8763c9fc2af40fe209ed4f2a2657
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Services\\Modules\\Auth\\' => 22,
            'Services\\Cor\\' => 13,
            'Services\\' => 9,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' => 
        array (
            'Modules\\Storage\\Create_folder_user\\' => 35,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Services\\Modules\\Auth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/modules/auth',
        ),
        'Services\\Cor\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/cor',
        ),
        'Services\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/../..' . '/libraries/email/vendor/phpmailer/phpmailer/src',
        ),
        'Modules\\Storage\\Create_folder_user\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/modules/storage',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services/tools/firebase/php-jwt/src',
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
