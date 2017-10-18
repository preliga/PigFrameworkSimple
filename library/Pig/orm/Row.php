<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-18
 * Time: 22:10
 */

namespace library\Pig\orm;

class Row
{
    protected $row;

    public function __construct(array $row)
    {
        $this->row = $row;
    }

    public function getArray(){
        return $this->row;
    }
}