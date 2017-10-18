<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use library\Pig\Router;

/**
 * Class App
 */
class App
{
    public function run()
    {
        spl_autoload_register(function ($class_name) {
            $str = "../$class_name.php";
            require $str;
        });

//        set_exception_handler(function(\Exception $exception){
////            die(var_dump($exception));
//            echo "Uncaught exception: " , $exception->getMessage(), "\n";
//        });

//        set_error_handler(function( int $errno , string $errstr, string $errfile, int $errline, array $errcontext ){
//            die(var_dump($errno, $errstr, $errfile, $errline, $errcontext));
//        });

        $baseUrl = $_SERVER['HTTP_HOST'] . '/';
        $url = empty($_SERVER['REDIRECT_URL']) ? '/' : $_SERVER['REDIRECT_URL'];

        $router = new Router($baseUrl);
        $router->route($url);
    }
}