<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace library\Pig\model;

use Zend_Db_Adapter_Mysqli;

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

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;

        $this->db = self::connect($config);
    }


    private static function connect($config) : Zend_Db_Adapter_Mysqli
    {
        if (empty(self::$adapter)) {
            return new Zend_Db_Adapter_Mysqli($config);
        } else {
            return self::$adapter;
        }
    }

    public function getDb(): Zend_Db_Adapter_Mysqli
    {
        return $this->db;
    }
}