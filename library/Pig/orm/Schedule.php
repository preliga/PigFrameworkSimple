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

    abstract protected function createSelect(): \Zend_Db_Select;

    abstract protected function createTreeDependency(): array;

    abstract protected function getValidators(): array;

    private function _getColumns(string $table = null): array
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

//    public function getKeys(string $table = null)
//    {
//        $treeDependency = $this->createTreeDependency();
//
//        if (!empty($table)) {
//            return $treeDependency['tables'][$table]['keys'];
//        } else {
//            $treeDependency = $this->createTreeDependency();
//
//            return $treeDependency['keys'];
//        }
//    }

    public function getKeyAlias(string $table = null): string
    {
        $treeDependency = $this->createTreeDependency();

        if (!empty($table)) {

            if (!is_int(key($treeDependency['tables'][$table]['keys']))) {
                return key($treeDependency['tables'][$table]['keys']);
            } else {
                return current($treeDependency['tables'][$table]['keys']);
            }

        } else {
            $treeDependency = $this->createTreeDependency();

            if (!is_int(key($treeDependency['keys']))) {
                return key($treeDependency['keys']);
            } else {
                return current($treeDependency['keys']);
            }

        }
    }

    public function getKeyName(string $table = null): string
    {
        $treeDependency = $this->createTreeDependency();

        if (!empty($table)) {

            return current($treeDependency['tables'][$table]['keys']);

        } else {
            $treeDependency = $this->createTreeDependency();

            return current($treeDependency['keys']);
        }
    }


    public function createRecord(): Record
    {
        $columns = $this->_getColumns();

        $record = [];

        foreach ($columns as $key => $val) {
            if (is_int($key)) {
                $record[$val] = null;
            } else {
                $record[$key] = null;
            }
        }

        return new Record($record, $this);
    }

    public function get($id): Record
    {
        $key = $this->getKeyName();

        return $this->findOne([$key . ' = ?' => $id]);
    }

    public function validateRecord(Record $record): array
    {
        $validators = $this->getValidators();

        foreach ($validators as $validate) {
            $result = $validate($record);

            if (!$result['status']) {
                return $result;
            }
        }

        return ['status' => true, 'message' => 'OK'];
    }

    public function beforeSaveRecord(Record $record, array $notTables = null): void
    {

    }

    public function saveRecord(Record $record, array $notTables = null): array
    {
        $treeDependency = $this->createTreeDependency();

        $this->db->beginTransaction();

        try {
            foreach ($treeDependency['tables'] as $table => $dependency) {

                if (!empty($table) && in_array($table, $notTables)) {
                    continue;
                }
                $bind = [];

                foreach ($dependency['columns'] as $key => $val) {

                    if (!$val instanceof \Zend_Db_Expr) {
                        $bind[$val] = $record->isProperty($key) ? $record->$key : $record->$val;
                    }
                }

                if ($record->isNew($table)) {
                    $this->db->insert($table, $bind);

                    $key = $this->getKeyAlias($table);

                    $record->$key = $this->db->lastInsertId($table);
                } else {
                    $where = [];

                    foreach ($dependency['keys'] as $key => $val) {
                        $where[] = "$table.$val = " . $this->db->quote($record->isProperty($key) ? $record->$key : $record->$val);
                    }

                    $this->db->update($table, $bind, $where);
                }
            }
        } catch (\Exception $e) {
            $this->db->rollBack();

            die(var_dump($e));
        }

        $this->db->commit();

        return ['status' => true, 'message' => 'OK'];
    }

    public function afterSaveRecord(Record $record, array $notTables = null): void
    {

    }

    public function find($where = null, $order = null): Collection
    {
        $select = $this->_find($where, $order);

        $collection = $this->db->fetchAll($select);

        return new Collection($collection);
    }

    public function findOne($where = null, $order = null): Record
    {
        $select = $this->_find($where, $order);

        $record = $this->db->fetchRow($select);

        return new Record($record, $this);
    }
}