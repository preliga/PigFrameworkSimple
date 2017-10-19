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

    public function save(Record $record)
    {
        $treeDependency = $this->createTreeDependency();

        if ($record->isNew()) {

        } else {
            foreach ($treeDependency['tables'] as $table => $dependency) {
                $bind = [];
                $where = [];

                foreach ($dependency['columns'] as $key => $val) {
                    if(! $val instanceof \Zend_Db_Expr) {
                        $bind[$val] = $record->$key ?? $record->$val;
                    }
                }

                foreach ($dependency['keys'] as $key => $val) {
                    $where[] = "$table.$val = " . $this->db->quote($record->$key ?? $record->$val);
                }

                $this->db->update($table, $bind, $where);
            }
        }
    }

    abstract protected function createSelect(): \Zend_Db_Select;

    abstract protected function createTreeDependency(): array;

    private function _getColumns(string $table = null)
    {
        $treeDependency = $this->createTreeDependency();

        if (!empty($table)) {
            return $treeDependency['tables'][$table]['columns'];
        } else {
            $allColumns = [];

            foreach ($treeDependency['tables'] as $table => $dependency) {
                $allColumns = array_merge($allColumns, $dependency['columns']);
            }

            return $allColumns;
        }
    }

//    private function _getMainKeys()
//    {
//        $treeDependency = $this->createTreeDependency();
//
//        return $treeDependency['keys'];
//    }

//    private function _getKeys(string $table = null)
//    {
//        $treeDependency = $this->createTreeDependency();
//
//        if (!empty($table)) {
//            return $treeDependency['tables'][$table]['keys'];
//        } else {
//            $allKeys = [];
//
//            foreach ($treeDependency['tables'] as $table => $dependency) {
//                $allKeys = array_merge($allKeys, $dependency['keys']);
//            }
//
//            return $allKeys;
//        }
//    }

    private function _find($where = null, $order = null): \Zend_Db_Select
    {
        $select = $this->createSelect();

        if (!empty($where)) {
            if (is_string($where)) {
                $select->where($where);
            } else if (is_array($where)) {
                foreach ($where as $key => $val) {
                    if (is_int($key)) {
                        $select->where($val);
                    } else {
                        $select->where($key, $val);
                    }
                }
            } else {
                throw new \Exception('Bad typ "where". Excepted array or string.');
            }
        }

        $treeDependency = $this->createTreeDependency();

        foreach ($treeDependency['tables'] as $table => $dependency) {

            $alias = $dependency['alias'] ?? $table;

            foreach ($dependency['columns'] as $key => $col) {
                $column = "$col";

                if (!is_int($key)) {
                    $column .= " AS $key";
                }

                $select->columns($column, $alias);
            }
        }

        return $select;
    }

    public static function createRecord()
    {
        $schedule = self::getInstance();
        $columns = $schedule->_getColumns();

        $record = [];

        foreach ($columns as $key => $val) {
            if (is_int($key)) {
                $record[$val] = null;
            } else {
                $record[$key] = null;
            }
        }

        return new Record($record, $schedule);
    }

    public static function getInstance(): Schedule
    {
        $class = get_called_class();
        if (self::$instance === null) {
            self::$instance = new $class();
        }

        return self::$instance;
    }

//    public static function get($id)
//    {
//        $schedule = self::getInstance();
//
//        $keys = $schedule->_getMainKeys();
//
//        if (count($keys) != count($id)) {
//            throw new \Exception('Bad main keys');
//        }
//
//        $select = $schedule->createSelect();
//
//        foreach ($keys as $key => $val) {
//            if(is_int($key)){
//                $select->where($val.' =',)
//            }
//        }
//    }

    public static function find($where = null, $order = null): Collection
    {
        $schedule = self::getInstance();

        $select = $schedule->_find($where, $order);

        $collection = $schedule->db->fetchAll($select);

        return new Collection($collection);
    }

    public static function findOne($where = null, $order = null): Record
    {
        $schedule = self::getInstance();

        $select = $schedule->_find($where, $order);

        $record = $schedule->db->fetchRow($select);

        return new Record($record, $schedule);
    }


}