<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-17
 * Time: 21:58
 */

namespace library\Pig\model;

/**
 * Class ScriptLoader
 * @package library\Pig\model
 */
class ScriptLoader
{
    /**
     * @var array
     */
    protected $js;

    /**
     * @var array
     */
    protected $css;

    /**
     * ScriptLoader constructor.
     */
    public function __construct()
    {
        $this->css = [];
        $this->js = [];
    }

    /**
     * @param string $path
     */
    public function addJS(string $path)
    {
        $this->js[] = $path;
    }

    /**
     * @param string $path
     */
    public function addCSS(string $path)
    {
        $this->css[] = $path;
    }

    /**
     * @return string
     */
    public function includeAllJS(): string
    {
        $script = "";

        foreach ($this->js as $path) {
            $script .= "<script src='$path'></script>";
        }

        return $script;
    }

    /**
     * @return string
     */
    public function includeAllCSS(): string
    {
        $script = "";

        foreach ($this->css as $path) {
            $script .= "<link rel='stylesheet' href='$path' ></link>";
        }

        return $script;
    }
}