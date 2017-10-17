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

    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy()
    {
        session_destroy();
    }
}

