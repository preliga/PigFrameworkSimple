<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-29
 * Time: 15:35
 */

use library\PigFramework\model\Config;
use library\PigOrm\action\Action;

class orm extends Action
{

    public function onAction()
    {
        $ormTemplatesPath = Config::getInstance()->getConfig('ormTemplatesPath');

        $dataModel = $this->getParam('dataModel');
        $dataModel = "{$ormTemplatesPath}{$dataModel}";

        $method = $this->getParam('method');
//        var_dump(json_encode(['test1' => 5, 'test2' => 5]));
//        die(var_dump($this->getParam('where')));
        
        $where = $this->getParam('where');
//        $where = json_decode("{'test1':5,'test2':5}");
//        die(var_dump($where));
        $this->view->where = $where;
        $this->view->method = $method;
        $this->view->dataModel = $dataModel;

        $this->view->data = $dataModel::getInstance()->$method()->getArray();

    }
}