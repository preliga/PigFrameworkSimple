<?php

$baseConfig = include ('../configs/base.config.php');

return array_merge(
    $baseConfig,
    [
        'db' => [
            'cinema' => [
                'driver' => 'Mysqli',
                'dbname' => 'cinema',
                'username' => 'root',
                'password' => ''
            ]
        ],
        'smarty' => [
            //debugging = true;
            'caching' => true,
            'cache_lifetime' => 0,
            'cache_dir' => '../cache/Smarty/cache',
            'compile_dir' => '../cache/Smarty/templates_c',
        ]
    ]
);