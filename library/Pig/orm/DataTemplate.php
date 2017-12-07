<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-18
 * Time: 22:11
 */

namespace library\Pig\orm;

abstract class DataTemplate
{
    /**
     * @var array
     */
    protected static $instances = [];

    /**
     * @var \Zend_Db_Adapter_Mysqli
     */
    protected $db;

    private function __construct()
    {
        $this->db = $this->getDb();
    }

    public static function getInstance(): DataTemplate
    {
        $class = get_called_class();

        if (empty(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }


    abstract protected function getDb(): \Zend_Db_Adapter_Mysqli;

    abstract protected function createSelect(array $variable = []): \Zend_Db_Select;

    abstract protected function createTreeDependency(): array;

    abstract protected function getValidators(): array;

    abstract protected function getPermission(): array;

    private function _getSelect(array $variable = []): \Zend_Db_Select
    {
        $select = $this->createSelect($variable);
        $select->reset(\Zend_Db_Select::COLUMNS);

        return $select;
    }


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

    private function _setColumns(\Zend_Db_Select $select)
    {
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
    }


    private function _setWhere(\Zend_Db_Select $select, $where)
    {
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
    }

    private function _setOrder(\Zend_Db_Select $select, $order)
    {
        if (!empty($order)) {
            $select->order($order);
        }
    }

    private function _setGroup(\Zend_Db_Select $select, $group)
    {
        if (!empty($group)) {
            $select->group($group);
        }
    }


    private function _aggregateFunction(string $typ, $column, $where = null, $group = null, array $variable = [])
    {
        $select = $this->_getSelect($variable);

        $select->columns(new \Zend_Db_Expr("$typ(" . $this->db->quote($column) . ")"));

        $this->_setColumns($select);
        $this->_setWhere($select, $where);
        $this->_setGroup($select, $group);

        return $this->db->fetchCol($select);
    }


    private function _find($where = null, $order = null, $group = null, array $variable = []): \Zend_Db_Select
    {
        if (!$this->_permission("GET")) {
            throw new \Exception("No rights (GET) to dataTemplate: " . get_called_class());
        }

        $select = $this->_getSelect($variable);

        $this->_setWhere($select, $where);
        $this->_setOrder($select, $order);
        $this->_setGroup($select, $group);

        $this->_setColumns($select);

        return $select;
    }

    private function _permission(string $type): bool
    {
        $type = strtoupper($type);
        if (!in_array($type, ['GET', 'PUT', 'POST', 'DELETE'])) {
            throw new \Exception("Bad type permission: '$type'");
        }

        $permission = $this->getPermission();

        return empty($permission[$type]) || $permission[$type]();
    }


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
            return current($treeDependency['keys']);
        }
    }

    public function getDefaultValues(string $table = null): array
    {
        $treeDependency = $this->createTreeDependency();

        if (!empty($table)) {

            return $treeDependency['tables'][$table]['defaultValues'] ?? [];

        } else {

            $values = [];
            foreach ($treeDependency['tables'] as $table) {
                $values = array_merge($values, $table['defaultValues'] ?? []);
            }

            return $values;
        }
    }


    public function createRecord(): Record
    {
        $columns = $this->_getColumns();

        $record = [];

        $defaultValues = $this->getDefaultValues();
        foreach ($columns as $key => $val) {
            if (is_int($key)) {
                $record[$val] = $defaultValues[$val] ?? null;
            } else {
                $record[$key] = $defaultValues[$key] ?? null;;
            }
        }

        return new Record($record, $this);
    }


    public function validateRecord(Record $record, string $column = null): array
    {
        $validators = $this->getValidators();
        $errors = [];

        if (empty($column)) {
            foreach ($validators as $col => $validType) {
                foreach ($validType as $validate) {
                    $result = $validate($record);

                    if (!$result['status']) {
                        $errors[] = array_merge($result, ['column' => $col]);
                    }
                }
            }
        } else {
            foreach ($validators[$column] as $validate) {
                $result = $validate($record);

                if (!$result['status']) {
                    $errors[] = array_merge($result, ['column' => $column]);
                }
            }
        }

        return ['status' => empty($errors), 'errors' => $errors];
    }

    public function validateCollection(Collection $collection, string $column = null): array
    {
        $errors = [];

        foreach ($collection as $record) {

            $valid = $record->validate($column);

            if (!$valid['status']) {
                $errors[$record->{$this->getKeyAlias()}][] = $valid['errors'];
            }
        }

        return ['status' => empty($errors), 'errors' => $errors];
    }


    public function beforeSaveCollection(Collection $collection, array $notTables = null, array $onlyTables = null)
    {

    }

    public function saveCollection(Collection $collection, array $notTables = null, array $onlyTables = null): array
    {
        $treeDependency = $this->createTreeDependency();

        $this->db->beginTransaction();

        foreach ($collection as $record) {

            try {
                foreach ($treeDependency['tables'] as $table => $dependency) {

                    if (!empty($notTables) && in_array($table, $notTables)) {
                        continue;
                    }
                    if (!empty($onlyTables) && !in_array($table, $onlyTables)) {
                        continue;
                    }

                    $bind = [];

                    foreach ($dependency['columns'] as $key => $val) {

                        if (!$val instanceof \Zend_Db_Expr) {
                            $bind[$val] = $record->isProperty($key) ? $record->$key : $record->$val;
                        }
                    }

                    if ($record->isNew($table)) {
                        if ($this->_permission('PUT')) {
                            $this->db->insert($table, $bind);
                            $key = $this->getKeyAlias($table);

                            $record->$key = $this->db->lastInsertId($table);
                        } else {
                            throw new \Exception("No rights (PUT) to dataTemplate: " . get_called_class());
                        }
                    } else {
                        if ($this->_permission('POST')) {
                            $where = [];

                            foreach ($dependency['keys'] as $key => $val) {
                                $where[] = "$table.$val = " . $this->db->quote($record->isProperty($key) ? $record->$key : $record->$val);
                            }

                            $this->db->update($table, $bind, $where);
                        } else {
                            throw new \Exception("No rights (POST) to dataTemplate: " . get_called_class());
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->db->rollBack();

                echo "<pre>";
                print_r($e);
                echo "</pre>";
                die();
            }
        }

        $this->db->commit();

        return ['status' => true, 'errors' => []];
    }

    public function afterSaveCollection(Collection $collection, array $notTables = null, array $onlyTables = null)
    {

    }


    public function beforeSetCollection(Collection $collection, $data)
    {

    }

    public function setColumns(Collection $collection, $data)
    {
        $treeDependency = $this->createTreeDependency();

        $tables = [];

        foreach ($treeDependency['tables'] as $tablesName => $table) {
            foreach ($table['columns'] as $key => $val) {
                if (is_int($key)) {
                    $alias = $val;
                } else {
                    $alias = $key;
                }

                if (isset($data[$alias])) {
                    if (empty($tables[$tablesName])) {
                        $tables[$tablesName] = [];
                    }

                    $tables[$tablesName][$val] = $data[$alias];
                }
            }
        }

        $this->db->beginTransaction();

        try {
            foreach ($tables as $tablesName => $bind) {

                $keys = $collection->getKeysCollection($tablesName);
                $this->db->update($tablesName, $bind, ["{$keys['column']} in (?)" => $keys['keys']]);

                foreach ($keys['newRecord'] as $record) {
                    $record->save(null, [$tablesName]);
                }
            }
        } catch (\Exception $e) {
            $this->db->rollBack();

            echo "<pre>";
            print_r($e);
            echo "</pre>";
            die();
        }

        $this->db->commit();

        $collection->load($data);

        return ['status' => true, 'errors' => []];
    }

    public function afterSetCollection(Collection $collection, $data)
    {

    }



    public function beforeDeleteCollection(Collection $collection, array $notTables = null, array $onlyTables = null)
    {

    }

    public function deleteCollection(Collection $collection, array $notTables = null, array $onlyTables = null): bool
    {
        $treeDependency = $this->createTreeDependency();

        $this->db->beginTransaction();

        foreach ($collection as $record) {
            try {
                foreach ($treeDependency['tables'] as $table => $dependency) {

                    if (!empty($notTables) && in_array($table, $notTables)) {
                        continue;
                    }
                    if (!empty($onlyTables) && !in_array($table, $onlyTables)) {
                        continue;
                    }

                    $bind = [];

                    foreach ($dependency['columns'] as $key => $val) {

                        if (!$val instanceof \Zend_Db_Expr) {
                            $bind[$val] = $record->isProperty($key) ? $record->$key : $record->$val;
                        }
                    }

                    if ($record->isNew($table)) {
                        throw new \Exception("This record was not save in date base");
                    } else {
                        $where = [];

                        foreach ($dependency['keys'] as $key => $val) {
                            $where[] = "$table.$val = " . $this->db->quote($record->isProperty($key) ? $record->$key : $record->$val);
                        }

                        $this->db->delete($table, $where);
                    }
                }
            } catch (\Exception $e) {
                $this->db->rollBack();

                die(var_dump($e));
            }
        }

        $this->db->commit();

        return true;
    }

    public function afterDeleteCollection(Collection $collection, array $notTables = null, array $onlyTables = null)
    {

    }


    public function beforeOutput(Collection $collection): Collection
    {
        return $collection;
    }


    public function get($id, array $variable = []): Record
    {
        $key = $this->getKeyName();

        return $this->findOne([$key . ' = ?' => $id], [], $variable);
    }

    public function find($where = null, $order = null, $group = null, array $variable = []): Collection
    {
        $select = $this->_find($where, $order, $group, $variable);

        $collection = $this->db->fetchAll($select);

        return $this->beforeOutput(new Collection($collection, $this));
    }

    public function findOne($where = null, $order = null, $group = null, array $variable = []): Record
    {
        $select = $this->_find($where, $order, $group, $variable);

        $record = $this->db->fetchRow($select);

        $collection = $this->beforeOutput(new Collection([!empty($record) ? $record : []], $this));

        return $collection->current();
    }


    public function exists($where = null, $group = null, array $variable = []): bool
    {
        $select = $this->_find($where, null, $group, $variable);

        return $this->db->fetchOne("SELECT EXISTS({$select})") == 1;
    }


    public function count($column, $where = null, $group = null, array $variable = [])
    {
        return $this->_aggregateFunction("COUNT", $column, $where, $group, $variable);
    }

    public function sum($column, $where = null, $group = null, array $variable = [])
    {
        return $this->_aggregateFunction("SUM", $column, $where, $group, $variable);
    }

    public function max($column, $where = null, $group = null, array $variable = [])
    {
        return $this->_aggregateFunction("MAX", $column, $where, $group, $variable);
    }

    public function min($column, $where = null, $group = null, array $variable = [])
    {
        return $this->_aggregateFunction("MIN", $column, $where, $group, $variable);
    }

    public function avg($column, $where = null, $group = null, array $variable = [])
    {
        return $this->_aggregateFunction("AVG", $column, $where, $group, $variable);
    }

}