<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace library\Pig\model;

/**
 * Class Config
 * @package library\Pig\model
 */
class Config
{
    /**
     * @var Config
     */
    public static $instance;

    /**
     * @var mixed
     */
    protected $config;

    /**
     * Config constructor.
     */
    private function __construct()
    {
        $this->config = include('../configs/' . APPLICATION_ENV . '.config.php');

        self::$instance = $this;
    }

    /**
     * @return Config
     */
    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return array
     */
    public function getAllConfig(): array
    {
        return $this->config;
    }

    /**
     * @param string $conf
     * @return array
     */
    public function getConfig(string $conf): array
    {
        return $this->config[$conf] ?? null;
    }
}