<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use library\Pig\Router;

class App
{
    public function run()
    {
        spl_autoload_register(function ($class_name) {
            $str = "../$class_name.php";
            require $str;
        });

        $baseUrl = $_SERVER['HTTP_HOST'].'/';
        $url = empty($_SERVER['REDIRECT_URL'])?'/':$_SERVER['REDIRECT_URL'];

        $router = new Router($baseUrl);
        $router->route($url);
    }
}