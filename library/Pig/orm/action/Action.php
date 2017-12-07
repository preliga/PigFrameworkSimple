<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-29
 * Time: 15:44
 */

namespace library\Pig\orm\action;

use library\Pig\model\View;

abstract class Action extends \library\Pig\action\Action
{
    final public function init()
    {
        $this->view = new View($this->file);
        $_GET['json'] = true;
    }

    public function permissionBase()
    {
    }

    final public function permissionStandard()
    {
    }

    public function permissionJSON()
    {
    }

    final public function preActionStandard()
    {
    }

    public function preActionJSON()
    {
    }

    public function preAction()
    {
    }

    public function postAction()
    {
    }

    final public function prepareRequest()
    {
        $this->view->prepareRequest();
    }

    final public function render()
    {
    }
}