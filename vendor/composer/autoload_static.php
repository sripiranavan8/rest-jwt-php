<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb8b25241e42cd277c4dfbf1ddf99d307
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb8b25241e42cd277c4dfbf1ddf99d307::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb8b25241e42cd277c4dfbf1ddf99d307::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb8b25241e42cd277c4dfbf1ddf99d307::$classMap;

        }, null, ClassLoader::class);
    }
}
