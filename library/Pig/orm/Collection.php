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
        $this->collection = $this->_createCollection($collection, $dataTemplate);

        $this->dataTemplate = $dataTemplate;
    }

    private function _createCollection(array $collection, DataTemplate $dataTemplate): array
    {
        $collectionRecord = [];

        foreach ($collection as $record) {
            if (is_array($record)) {
                $collectionRecord[] = new Record($record, $dataTemplate);
            } else {
                $collectionRecord[] = $record;
            }
        }

        return $collectionRecord;
    }

    public function getKeysCollection($table = null)
    {
        $keyName = $this->dataTemplate->getKeyName($table);
        $keyAlias = $this->dataTemplate->getKeyAlias($table);

        $keysArray = [];
        $newRecords = [];

        foreach ($this as $record) {
            if (!empty($record->$keyAlias) || is_int($record->$keyAlias)) {
                $keysArray[] = $record->$keyAlias;
            } else {
                $newRecords[] = $record;
            }
        }

        return ['column' => $keyName, 'keys' => $keysArray, 'newRecords' => $newRecords];
    }

    public function getHash()
    {
        return sha1(json_encode($this->getArray(true)));
    }

    public function reload()
    {
        $keys = $this->getKeysCollection();

        $collection = $this->dataTemplate->find(["{$keys['column']} in (?)" => $keys['keys']]);

        $this->collection = $collection->collection;
    }


    public function validate(string $column = null): array
    {
        return $this->dataTemplate->validateCollection($this, $column);
    }

    public function save($notTables = null, $onlyTables = null, bool $reload = true): array
    {
        if (empty($this->collection)) {
            return ['status' => false, 'errors' => ["Empty collection"]];
        }

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
        if (empty($this->collection)) {
            return ['status' => false, 'errors' => ["Empty collection"]];
        }

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


    public function filter($callback): Collection
    {
        $collection = [];
        foreach ($this as $record) {
            if ($callback($record)) {
                $collection[] = $record;
            }
        }

        return new Collection($collection, $this->dataTemplate);
    }

    public function marge(Collection $collection, $withDouble = true): Collection
    {
        if (get_class($this->dataTemplate) != get_class($collection->dataTemplate)) {
            throw new \Exception("Bad collection dataTemplate");
        }

        if ($withDouble) {
            $collectionNew = array_merge($this->collection, $collection->collection);
        } else {


            $getCollectionWithoutDouble = function ($collection, &$collectionNew) {
                foreach ($collection as $newRecord) {

                    $isUnique = true;

                    $hash = $newRecord->getHash();

                    foreach ($collectionNew as $oldRecord) {
                        if ($hash == $oldRecord->getHash()) {
                            $isUnique = false;
                            break;
                        }
                    }

                    if ($isUnique) {
                        $collectionNew[] = $newRecord;
                    }
                }

                return $collectionNew;
            };

            $collectionNew = [];

            $getCollectionWithoutDouble($this->collection, $collectionNew);
            $getCollectionWithoutDouble($collection->collection, $collectionNew);
        }

        return new Collection($collectionNew, $this->dataTemplate);
    }

    public function addRecord(Record $record, $withDouble = true)
    {
        if (get_class($this->dataTemplate) != get_class($record->dataTemplate)) {
            throw new \Exception("Bad record dataTemplate");
        }

        if ($withDouble) {
            $this->collection[] = $record;
        } else {

            $isUnique = true;

            $hash = $record->getHash();

            foreach ($this->collection as $oldRecord) {
                if ($hash == $oldRecord->getHash()) {
                    $isUnique = false;
                    break;
                }
            }

            if ($isUnique) {
                $this->collection[] = $record;
            }
        }
    }

    public function reset()
    {
        $this->collection = [];
    }


    public function set($data, bool $reload = true)
    {
        if (empty($this->collection)) {
            return ['status' => false, 'errors' => ["Empty collection"]];
        }

        $valid = $this->validate();

        if (!$valid['status']) {
            return $valid;
        } else {

            $this->dataTemplate->beforeSetCollection($this, $data);
            $this->dataTemplate->setColumns($this, $data);
            $this->dataTemplate->afterSetCollection($this, $data);

            if ($reload) {
                $this->reload();
            }

            return ['status' => true, 'errors' => []];
        }
    }

    public function load(array $data)
    {
        foreach ($this as $record) {
            $record->load($data);
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