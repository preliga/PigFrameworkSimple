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
     * @var string
     */
    protected $file;

    public function __construct(string $file)
    {
        Session::init();
        $this->file = $file;
    }

    public function init()
    {
        $this->view = new View($this->file);
    }

    public function permissionBase()
    {
    }

    public function permissionStandard()
    {
    }

    public function permissionJSON()
    {
    }

    public function preActionStandard()
    {
    }

    public function preActionJSON()
    {
    }

    public function preAction()
    {
    }

    abstract public function onAction();

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

    public function redirect(
        string $url = "/",
        array $params = [],
        bool $status = true,
        string $message = "",
        array $data = []
    )
    {
        $this->view->status = $status ? 'success' : 'error';
        $this->view->message = $message;

        if ($this->hasParam('json')) {
            $this->view->prepareRequest($data);
            die();
        } else {

            if (!empty($params)) {
                $query = '?';
                foreach ($params as $key => $val) {
                    $query .= "$key=$val";
                }
                $url .= $query;
            }

            header("Location: {$url}");
            die();
        }
    }

    public function addJS(string $path)
    {
        $this->view->scriptLoader->addJS($path);
    }

    public function addCSS(string $path)
    {
        $this->view->scriptLoader->addCSS($path);
    }

    public function getParams(): array
    {
        return $_GET;
    }

    public function getParam($name, $default = null)
    {
        return $_GET[$name] ?? $default;
    }

    public function hasParam($name): bool
    {
        return !empty($_GET[$name]);
    }

    public function getPost($name = null, $default = null)
    {
        if (!empty($name)) {
            return $_POST[$name] ?? $default;
        } else {
            return $_POST ?? $default;
        }
    }

    public function hasPost($name = null): bool
    {
        if (!empty($name)) {
            return !empty($_POST[$name]);
        } else {
            return !empty($_POST);
        }
    }
}
