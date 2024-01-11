<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2c63fa6b3ea3254d2ed81bbc560b5e63
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Shumonpal\\ProjectSecurity\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Shumonpal\\ProjectSecurity\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2c63fa6b3ea3254d2ed81bbc560b5e63::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2c63fa6b3ea3254d2ed81bbc560b5e63::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2c63fa6b3ea3254d2ed81bbc560b5e63::$classMap;

        }, null, ClassLoader::class);
    }
}