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

    protected $dataTemplate;

    public function __construct(array $collection, dataTemplate $dataTemplate)
    {
        $this->collection = $this->createCollection($collection, $dataTemplate);

        $this->dataTemplate = $dataTemplate;
    }

    private function createCollection(array $collection, dataTemplate $dataTemplate): array
    {
        $collectionRecord = [];

        foreach ($collection as $record) {
            $collectionRecord[] = new Record($record, $dataTemplate);
        }

        return $collectionRecord;
    }

    public function validate(string $column = null): array
    {
        return $this->dataTemplate->validateCollection($this, $column);
    }

    public function save($notTables = null, $onlyTables = null): array
    {
        $valid = $this->validate();

        if (!$valid['status']) {
            return $valid;
        } else {
            foreach ($this as $record) {

                $this->dataTemplate->beforeSaveRecord($record, $notTables, $onlyTables);
                $this->dataTemplate->saveRecord($record, $notTables, $onlyTables);
                $this->dataTemplate->afterSaveRecord($record, $notTables, $onlyTables);
            }

            return ['status' => true, 'errors' => []];
        }
    }

    public function delete($notTables = null, $onlyTables = null): array
    {
        foreach ($this as $record) {

            $this->dataTemplate->beforeDeleteRecord($record, $notTables, $onlyTables);
            $this->dataTemplate->deleteRecord($record, $notTables, $onlyTables);
            $this->dataTemplate->afterDEleteRecord($record, $notTables, $onlyTables);
        }

        return ['status' => true, 'errors' => []];
    }

    public function getArray(bool $deepArray = true): array
    {
        if ($deepArray) {
            $collection = [];
            foreach ($this->collection as $record) {
                $collection[] = $record->getArray();
            }

            return $collection;
        } else {
            return $this->collection;
        }
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