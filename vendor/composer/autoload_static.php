<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4a954a6dcc5c3eea441cd68b346b9ba0
{
    public static $files = array (
        'f084d01b0a599f67676cffef638aa95b' => __DIR__ . '/..' . '/smarty/smarty/libs/bootstrap.php',
    );

    public static $prefixesPsr0 = array (
        'Z' => 
        array (
            'Zend_' => 
            array (
                0 => __DIR__ . '/../..' . '/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit4a954a6dcc5c3eea441cd68b346b9ba0::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
