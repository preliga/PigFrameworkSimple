<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace library\Pig;

use library\Pig\model\Config;
use library\Pig\model\PigException;

/**
 * Class Router
 * @package library\Pig
 */
class Router
{
    /**
     * Router constructor.
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $url
     * @throws \Exception
     */
    public function route(string $url)
    {
        $appPath = Config::getInstance()->getConfig('appPath');
        $action = null;
        if (empty($url) || $url == '/' || $url == '/index.php') {
            $file = "content{$appPath}/index";
            require "{$file}.php";
            $action = new \index($file);
        } else {

            $array_url = explode("/", $url);
            $path = "content{$appPath}";

            foreach ($array_url as $param) {
                $path = $path . $param;

                if (is_dir($path)) {
                    $path .= "/";
                } else {
                    try {
                        require $path . '.php';
                    } catch (\Exception $e) {
                        die(var_dump($e));
                    }
                    $actionString = "{$param}";
                    $action = new $actionString($path);
                }
            }
        }

        if (!empty($action)) {
            $action->init();
            $action->permissionBase();

            if (!$action->hasParam('json')) {
                $action->permissionStandard();
                $action->preActionStandard();
            } else {
                $action->permissionJSON();
                $action->preActionJSON();
            }

            $action->preAction();
            $action->onAction();
            $action->postAction();

            if (!$action->hasParam('json')) {
                $action->render();
            } else {
                $action->prepareRequest();
            }

        } else {
            throw new \Exception("Błąd przekierowanie");
        }
    }

}
