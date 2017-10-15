<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace library\Pig;

class Router {

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function route($url)
    {
        $action = null;
        if (empty($url) || $url == '/' || $url == '/index.php') {
            require 'content/index.php';
            $action = new \index('content/index');
        } else {

            $array_url = explode("/", $url);
            $path = 'content';

            foreach ($array_url as $param) {
                $path = $path . $param;

                if (is_dir($path)) {
                    $path .= "/";
                }
                else
                {
                    try
                    {
                        require $path . '.php';
                    } catch (\Exception $e) {
                        die(var_dump($e));
                    }
                    $actionString = "{$param}";
                    $action = new $actionString($path);
                }
            }
        }

        if(!empty($action))
        {
            $action->init();
            $action->permission();

            if(!$action->hasParam('json')) {
                $action->preAction();
            } else {
                $action->preActionJSON();
            }

            $action->prepareAction();
            $action->onAction();
            $action->postAction();

            if(!$action->hasParam('json')) {
                $action->render();
            } else {
                $action->prepareRequest();
            }

        } else {
            throw new \Exception("Błąd przekierowanie");
        }
    }

}
