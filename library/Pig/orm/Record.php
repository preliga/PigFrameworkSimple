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

    public function __construct(array $record, Schedule $schedule)
    {
        $this->schedule = $schedule;
        foreach ($record as $key => $val) {
            $this->$key = $val;
        }
    }

    public function getArray(): array
    {
        $publicVars = create_function('$obj', 'return get_object_vars($obj);');
        $result = $publicVars($this);

        return $result;
    }

    public function isNew(){
        return false; // todo zaimplementować isNew
    }

    public function save(){
        $this->schedule->save($this);
    }
}