<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */


namespace library\Pig\model;

class Session
{

    public static function init()
    {
        session_start();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function destroy()
    {
        session_destroy();
    }
}

