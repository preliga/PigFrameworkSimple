<?php

/*
 * Zwraca tablicę dla klasy config
 * Tu jest definicja bazy danych
 */

return [
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
];