<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-17
 * Time: 21:58
 */

namespace library\Pig\model;

class ScriptLoader
{
    protected $js;
    protected $css;

    public function __construct()
    {
        $this->css = [];
        $this->js = [];
    }

    public function addJS(string $path)
    {
        $this->js[] = $path;
    }

    public function addCSS(string $path)
    {
        $this->css[] = $path;
    }

    public function includeAllJS(): string
    {
        $script = "";

        foreach ($this->js as $path) {
            $script .= "<script src='$path'></script>";
        }

        return $script;
    }

    public function includeAllCSS(): string
    {
        $script = "";

        foreach ($this->css as $path) {
            $script .= "<link rel='stylesheet' href='$path' ></link>";
        }

        return $script;
    }
}