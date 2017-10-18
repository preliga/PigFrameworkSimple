<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */


namespace library\Pig\model;

/**
 * Class Session
 * @package library\Pig\model
 */
class Session
{
    /**
     *
     */
    public static function init()
    {
        session_start();
    }

    /**
     * @param string $key
     * @param $value
     */
    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return
     */
    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     *
     */
    public static function destroy()
    {
        session_destroy();
    }
}

