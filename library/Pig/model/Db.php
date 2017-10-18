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
    private static $adapter;

    /**
     * @var Zend_Db_Adapter_Mysqli
     */
    protected $db;

    /**
     * @var array
     */
    protected $config;

    /**
     * Db constructor.
     * @param $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->db = self::connect($config);
    }

    /**
     * @param $config
     * @return Zend_Db_Adapter_Mysqli
     */
    private static function connect($config): Zend_Db_Adapter_Mysqli
    {
        if (empty(self::$adapter)) {
            return new Zend_Db_Adapter_Mysqli($config);
        } else {
            return self::$adapter;
        }
    }

    /**
     * @return Zend_Db_Adapter_Mysqli
     */
    public function getDb(): Zend_Db_Adapter_Mysqli
    {
        return $this->db;
    }
}