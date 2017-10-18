<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-18
 * Time: 22:11
 */

namespace library\Pig\orm;

use library\Pig\model\Config;
use library\Pig\model\Db;

abstract class Schedule
{
    protected static $instance;

    protected $db;

    private function __construct()
    {
        $config = Config::getInstance()->getConfig('db');
        $db = new Db($config['cinema']);
        $this->db = $db->getDb();
    }

    public static function getInstance(): Schedule
    {
        $class = get_called_class();
        if (self::$instance === null) {
            self::$instance = new $class();
        }

        return self::$instance;
    }


    public function createSelect(): \Zend_Db_Select
    {
        $select = $this->db->select();

        return $select;
    }

    private function _find($where = null, $order = null): \Zend_Db_Select
    {
        $select = $this->createSelect();

        if (!empty($where)) {
            if (is_string($where)) {
                $select->where($where);
            } else if (is_array($where)) {
                foreach ($where as $key => $val) {
                    $select->where($key, $val);
                }
            } else {
                throw new \Exception('Bad typ "where". Excepted array or string.');
            }
        }

        return $select;
    }


    public static function find($where = null, $order = null): Collection
    {
        $schedule = self::getInstance();

        $select = $schedule->_find($where,$order);

        $collection = $schedule->db->fetchAll($select);

        return new Collection($collection);
    }

    public static function findOne($where = null, $order = null): Row
    {
        $schedule = self::getInstance();

        $select = $schedule->_find($where,$order);

        $row = $schedule->db->fetchRow($select);

        return new Row($row);
    }
}