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
    /**
     * @var array
     */
    protected $collection;

    /**
     * @var DataTemplate
     */
    protected $dataTemplate;

    public function __construct($collection, DataTemplate $dataTemplate)
    {
        $this->collection = $this->createCollection($collection, $dataTemplate);

        $this->dataTemplate = $dataTemplate;
    }

    private function createCollection(array $collection, DataTemplate $dataTemplate): array
    {
        $collectionRecord = [];

        foreach ($collection as $record) {
            if(is_array($record)) {
                $collectionRecord[] = new Record($record, $dataTemplate);
            } else {
                $collectionRecord[] = $record;
            }
        }

        return $collectionRecord;
    }

    public function validate(string $column = null): array
    {
        return $this->dataTemplate->validateCollection($this, $column);
    }

    public function reload()
    {
        $keyName = $this->dataTemplate->getKeyName();
        $keyAlias = $this->dataTemplate->getKeyAlias();

        $keysArray = [];

        foreach ($this as $record) {
            $keysArray[] = $record->$keyAlias;
        }

        $collection = $this->dataTemplate->find(["$keyName in (?)" => $keysArray]);

        $this->collection = $collection->collection;
    }

    public function save($notTables = null, $onlyTables = null, $reload = true): array
    {
        $valid = $this->validate();

        if (!$valid['status']) {
            return $valid;
        } else {

            $this->dataTemplate->beforeSaveCollection($this, $notTables, $onlyTables);
            $this->dataTemplate->saveCollection($this, $notTables, $onlyTables);
            $this->dataTemplate->afterSaveCollection($this, $notTables, $onlyTables);

            if ($reload) {
                $this->reload();
            }

            return ['status' => true, 'errors' => []];
        }
    }

    public function delete($notTables = null, $onlyTables = null): array
    {
        $this->dataTemplate->beforeDeleteCollection($this, $notTables, $onlyTables);
        $this->dataTemplate->deleteCollection($this, $notTables, $onlyTables);
        $this->dataTemplate->afterDEleteCollection($this, $notTables, $onlyTables);

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