<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-18
 * Time: 22:10
 */

namespace library\Pig\orm;

use Iterator;

class Collection implements Iterator
{
    protected $collection;

    protected $schedule;

    public function __construct(array $collection, Schedule $schedule)
    {
        $this->collection = $this->createCollection($collection, $schedule);

        $this->schedule = $schedule;
    }

    private function createCollection(array $collection, Schedule $schedule): array
    {
        $collectionRecord = [];

        foreach ($collection as $record) {
            $collectionRecord[] = new Record($record, $schedule);
        }

        return $collectionRecord;
    }

    public function validate(string $column = null): array
    {
        return $this->schedule->validateCollection($this, $column);
    }

    public function save($notTables = null, $onlyTables = null): array
    {
        $valid = $this->validate();

        if (!$valid['status']) {
            return $valid;
        } else {
            foreach ($this as $record) {

                $this->schedule->beforeSaveRecord($record, $notTables, $onlyTables);
                $this->schedule->saveRecord($record, $notTables, $onlyTables);
                $this->schedule->afterSaveRecord($record, $notTables, $onlyTables);
            }

            return ['status' => true, 'errors' => []];
        }
    }

    public function delete($notTables = null, $onlyTables = null): array
    {
        foreach ($this as $record) {

            $this->schedule->beforeDeleteRecord($record, $notTables, $onlyTables);
            $this->schedule->deleteRecord($record, $notTables, $onlyTables);
            $this->schedule->afterDEleteRecord($record, $notTables, $onlyTables);
        }

        return ['status' => true, 'errors' => []];
    }

    public function getArray()
    {
        return $this->collection;
    }

    public function current()
    {
        return current($this->collection);
    }

    public function next()
    {
        return next($this->collection);
    }

    public function key()
    {
        return key($this->collection);
    }

    public function valid()
    {
        $key = key($this->collection);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    public function rewind()
    {
        reset($this->collection);
    }
}