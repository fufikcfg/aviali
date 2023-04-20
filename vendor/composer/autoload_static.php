<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5666652f71a73e85f8650cdbf14d47cd
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5666652f71a73e85f8650cdbf14d47cd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5666652f71a73e85f8650cdbf14d47cd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5666652f71a73e85f8650cdbf14d47cd::$classMap;

        }, null, ClassLoader::class);
    }
}
