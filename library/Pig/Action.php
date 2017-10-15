<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */


namespace library\Pig;

use library\Pig\model\{
    Session, View
};

abstract class Action
{
    /**
     * @var View
     */
    protected $view;

    /**
     * @var String
     */
    private $file;

    public function __construct($file)
    {
        Session::init();
        $this->file = $file;
    }

    public function init()
    {
        $this->view = new View($this->file);
    }

    public function permission()
    {

    }

    public function preAction()
    {

    }

    public function preActionJSON()
    {

    }

    public function prepareAction()
    {

    }

    public function onAction()
    {

    }

    public function postAction()
    {

    }

    public function prepareRequest()
    {
        $this->view->prepareRequest();
    }

    public function render()
    {
        $this->view->render();
    }

    public function redirect($url)
    {
        header("Location: {$url}");
        die();
    }

    public function getParams()
    {
        return $_GET;
    }

    public function getParam($name, $default = null)
    {

        if (!$this->hasParam($name)) {
            return $default;
        }

        return $_GET[$name];
    }

    public function hasParam($name)
    {
        return !empty($_GET[$name]);
    }

    public function getPost($name = null, $default = null)
    {

        if (!$this->hasPost($name)) {
            return $default;
        }

        if (!empty($name)) {
            return $_POST[$name];
        } else {
            return $_POST;
        }
    }

    public function hasPost($name = null)
    {
        if (!empty($name)) {
            return !empty($_POST[$name]);
        } else {
            return !empty($_POST);
        }
    }
}
