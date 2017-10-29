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
    /**
     * @var DataTemplate
     */
    protected $dataTemplate;

    /**
     * @var array
     */
    protected $record;

    public function __construct(array $record, DataTemplate $dataTemplate)
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

    public function getHash()
    {
        return sha1(json_encode($this->record));
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

    public function load($data){

        if($data instanceof Record){
            $data = $data->record;
        }

        foreach ($data as $key => $val) {
            if($this->isProperty($key)) {
                $this->record[$key] = $val;
            }
        }
    }


    public function save($notTables = null, $onlyTables = null, bool $reload = true): array
    {
        $valid = $this->dataTemplate->validateRecord($this);

        if (!$valid['status']) {
            return $valid;
        } else {

            $collection = new Collection([$this], $this->dataTemplate);
            $this->dataTemplate->beforeSaveCollection($collection, $notTables, $onlyTables);
            $this->dataTemplate->saveCollection($collection, $notTables, $onlyTables);
            $this->dataTemplate->afterSaveCollection($collection, $notTables, $onlyTables);

            if($reload) {
                $this->reload();
            }

            return ['status' => true, 'errors' => []];
        }
    }

    public function delete(array $notTables = null, array $onlyTables = null): array
    {
        $collection = new Collection([$this], $this->dataTemplate);

        $this->dataTemplate->beforeDeleteCollection($collection, $notTables, $onlyTables);
        $this->dataTemplate->deleteCollection($collection, $notTables, $onlyTables);
        $this->dataTemplate->afterDeleteCollection($collection, $notTables, $onlyTables);

        return ['status' => true, 'errors' => []];
    }

    public function validate(string $column = null): array
    {
        return $this->dataTemplate->validateRecord($this, $column);
    }
}