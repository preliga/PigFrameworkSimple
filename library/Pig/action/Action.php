<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace library\Pig\action;

use library\Pig\model\{
    Session, Statement, View
};

/**
 * Class Action
 * @package library\Pig\action
 */
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

    /**
     * @var Statement
     */
    protected $statement;

    /**
     * Action constructor.
     * @param string $file
     */
    public function __construct(string $file)
    {
        Session::init();
        $this->file = $file;
    }

    /**
     *
     */
    public function init()
    {
        $this->view = new View($this->file);
        $this->statement = Statement::getInstance();
    }

    /**
     *
     */
    public function permissionBase()
    {
    }

    /**
     *
     */
    public function permissionStandard()
    {
    }

    /**
     *
     */
    public function permissionJSON()
    {
    }

    /**
     *
     */
    public function preActionStandard()
    {
    }

    /**
     *
     */
    public function preActionJSON()
    {
    }

    /**
     *
     */
    public function preAction()
    {
    }

    /**
     * @return mixed
     */
    abstract public function onAction();

    /**
     *
     */
    public function postAction()
    {
    }

    /**
     *
     */
    public function prepareRequest()
    {
        $this->view->prepareRequest();
    }

    /**
     *
     */
    public function render()
    {
        $data = [
            'post' => $this->getPost(),
            'params' => $this->getParams(),
            'statement' => $this->statement->popStatements()
        ];

        $this->view->render($data);
    }

    /**
     * @param string $url
     * @param array $params
     * @param bool $status
     * @param string $message
     * @param array $data
     */
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

    /**
     * @param string $path
     */
    public function addJS(string $path)
    {
        $this->view->scriptLoader->addJS($path);
    }

    /**
     * @param string $path
     */
    public function addCSS(string $path)
    {
        $this->view->scriptLoader->addCSS($path);
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $_GET;
    }

    /**
     * @param $name
     * @param null $default
     * @return null
     */
    public function getParam($name, $default = null)
    {
        return $_GET[$name] ?? $default;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasParam($name): bool
    {
        return !empty($_GET[$name]);
    }

    /**
     * @param null $name
     * @param null $default
     * @return null
     */
    public function getPost($name = null, $default = null)
    {
        if (!empty($name)) {
            return $_POST[$name] ?? $default;
        } else {
            return $_POST ?? $default;
        }
    }

    /**
     * @param null $name
     * @return bool
     */
    public function hasPost($name = null): bool
    {
        if (!empty($name)) {
            return !empty($_POST[$name]);
        } else {
            return !empty($_POST);
        }
    }
}
