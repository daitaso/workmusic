<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit457b89a5cdf46151e10f6d919a8532b6
{
    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpseclib\\' => 10,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'F' => 
        array (
            'Fuel\\Upload\\' => 12,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpseclib\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'Fuel\\Upload\\' => 
        array (
            0 => __DIR__ . '/..' . '/fuelphp/upload/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 
            array (
                0 => __DIR__ . '/..' . '/psr/log',
            ),
        ),
        'M' => 
        array (
            'Michelf' => 
            array (
                0 => __DIR__ . '/..' . '/michelf/php-markdown',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit457b89a5cdf46151e10f6d919a8532b6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit457b89a5cdf46151e10f6d919a8532b6::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit457b89a5cdf46151e10f6d919a8532b6::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
