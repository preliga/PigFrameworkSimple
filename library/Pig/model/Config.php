<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace library\Pig\model;

class Config
{
    public static $instance;

    protected $config;

    private function __construct()
    {
        $this->config = include('../configs/' . APPLICATION_ENV . '.config.php');

        self::$instance = $this;
    }

    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getAllConfig(): array
    {
        return $this->config;
    }

    public function getConfig(string $conf)
    {
        return $this->config[$conf] ?? null;
    }
}