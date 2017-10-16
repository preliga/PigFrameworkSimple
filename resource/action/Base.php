<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace resource\action;

use library\Pig\Action;
use library\Pig\model\Config;
use resource\model\Db;

class Base extends Action
{
    protected $db;

    public function init()
    {
        parent::init();
        $config = Config::getInstance()->getConfig('db');
        $db = new Db($config['cinema']);
        $this->db = $db->getDb();
    }
}