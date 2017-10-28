<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-18
 * Time: 22:10
 */

namespace library\Pig\orm;

class Record
{
    protected $dataTemplate;

    protected $record;

    public function __construct(array $record, dataTemplate $dataTemplate)
    {
        $this->dataTemplate = $dataTemplate;

        $this->record = $record;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->record)) {
            return $this->record[$name];
        } else {
            throw new \Exception("Not found property: '$name'");
        }
    }

    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->record)) {
            $this->record[$name] = $value;
        } else {
            throw new \Exception("Not found property: '$name'");
        }
    }

    public function isProperty($name): bool
    {
        return array_key_exists($name, $this->record);
    }

    public function getArray(): array
    {
        return $this->record;
    }

    public function isNew(string $table = null): bool
    {
        $key = $this->dataTemplate->getKeyAlias($table);

        return is_null($this->$key);
    }

    public function reload()
    {
        $key = $this->dataTemplate->getKeyAlias();

        $this->record = $this->dataTemplate->get($this->$key)->getArray();
    }

    public function save($notTables = null, $onlyTables = null, $reload = true): array
    {
        $valid = $this->dataTemplate->validateRecord($this);

        if (!$valid['status']) {
            return $valid;
        } else {
            $this->dataTemplate->beforeSaveRecord($this, $notTables, $onlyTables);
            $this->dataTemplate->saveRecord($this, $notTables, $onlyTables);
            $this->dataTemplate->afterSaveRecord($this, $notTables, $onlyTables);

            if($reload) {
                $this->reload();
            }

            return ['status' => true, 'errors' => []];
        }
    }

    public function delete(array $notTables = null, array $onlyTables = null): array
    {
        $this->dataTemplate->beforeDeleteRecord($this, $notTables, $onlyTables);
        $this->dataTemplate->deleteRecord($this, $notTables, $onlyTables);
        $this->dataTemplate->afterDeleteRecord($this, $notTables, $onlyTables);

        return ['status' => true, 'errors' => []];
    }

    public function validate(string $column = null): array
    {
        return $this->dataTemplate->validateRecord($this, $column);
    }
}