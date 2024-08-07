<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita0f60806a5da9588ba0bbfc1a1ab2ffc
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita0f60806a5da9588ba0bbfc1a1ab2ffc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita0f60806a5da9588ba0bbfc1a1ab2ffc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita0f60806a5da9588ba0bbfc1a1ab2ffc::$classMap;

        }, null, ClassLoader::class);
    }
}
