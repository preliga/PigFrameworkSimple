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
    protected $schedule;

    protected $record;

    public function __construct(array $record, Schedule $schedule)
    {
        $this->schedule = $schedule;

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
        $key = $this->schedule->getKeyAlias($table);

        return is_null($this->$key);
    }

    public function reload(): void
    {
        $key = $this->schedule->getKeyAlias();

        $this->record = $this->schedule->get($this->$key)->getArray();
    }

    public function save(array $notTables = null, array $onlyTables = null): array
    {
        $valid = $this->schedule->validateRecord($this);

        if (!$valid['status']) {
            return $valid;
        } else {
            $this->schedule->beforeSaveRecord($this, $notTables, $onlyTables);
            $this->schedule->saveRecord($this, $notTables, $onlyTables);
            $this->schedule->afterSaveRecord($this, $notTables, $onlyTables);

            return ['status' => true, 'errors' => []];
        }
    }

    public function delete(array $notTables = null, array $onlyTables = null): array
    {
        $this->schedule->beforeDeleteRecord($this, $notTables, $onlyTables);
        $this->schedule->deleteRecord($this, $notTables, $onlyTables);
        $this->schedule->afterDeleteRecord($this, $notTables, $onlyTables);

        return ['status' => true, 'errors' => []];
    }

    public function validate(string $column = null): array
    {
        return $this->schedule->validateRecord($this, $column);
    }
}