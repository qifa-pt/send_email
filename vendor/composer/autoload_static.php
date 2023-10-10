<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitabe1ac9bfc9767d8fce229daa4c575ed
{
    public static $prefixLengthsPsr4 = array (
        'l' => 
        array (
            'l3n641\\SendEmail\\' => 17,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'l3n641\\SendEmail\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitabe1ac9bfc9767d8fce229daa4c575ed::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitabe1ac9bfc9767d8fce229daa4c575ed::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitabe1ac9bfc9767d8fce229daa4c575ed::$classMap;

        }, null, ClassLoader::class);
    }
}
