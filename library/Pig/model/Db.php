<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace library\Pig\model;

use Zend_Db_Adapter_Mysqli;

/**
 * Class Db
 * @package library\Pig\model
 */
class Db
{
    /**
     * @var Zend_Db_Adapter_Mysqli
     */
    protected $db;

    /**
     * @var array
     */
    protected $config;

    protected static $instances = [];

    public static function getInstance(array $config, string $name)
    {
        if (empty(self::$instances[$name])) {
            self::$instances[$name] = new self($config);
        }

        return self::$instances[$name];
    }

    /**
     * Db constructor.
     * @param $config
     */
    private function __construct(array $config)
    {
        $this->config = $config;

        $this->db = self::connect($config);
    }

    /**
     * @param $config
     * @return Zend_Db_Adapter_Mysqli
     */
    private function connect($config): Zend_Db_Adapter_Mysqli
    {
        return new Zend_Db_Adapter_Mysqli($config);
    }

    /**
     * @return Zend_Db_Adapter_Mysqli
     */
    public function getDb(): Zend_Db_Adapter_Mysqli
    {
        return $this->db;
    }
}