<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcf0ed3fd140f81e1fd5b389640a824a5
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcf0ed3fd140f81e1fd5b389640a824a5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcf0ed3fd140f81e1fd5b389640a824a5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitcf0ed3fd140f81e1fd5b389640a824a5::$classMap;

        }, null, ClassLoader::class);
    }
}
