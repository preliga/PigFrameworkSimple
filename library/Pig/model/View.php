<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace library\Pig\model;

class View
{
    public function __construct(String $file, String $template = 'standard')
    {
        $this->file = $file;
        $this->fileJsExist = file_exists("$this->file.js");

        $this->template = $template;

        $this->path = explode('/', $file);
    }

    public function setTemplate(String $template)
    {
        $this->template = $template;
    }

    public function render()
    {
        $smarty = new \Smarty();
        $smartyOptions = Config::getInstance()->getConfig('smarty');

        foreach ($smartyOptions as $key => $val) {
            $smarty->$key = $val;
        }

        $this->assignVariable($smarty);
        $tpl = "layout/templates/{$this->template}.tpl";

        if (file_exists($tpl)) {
                $smarty->display($tpl);
        } else {
            die(var_dump("Not found template: $tpl"));
        }
    }

    public function prepareRequest()
    {
        $publicVars = create_function('$obj', 'return get_object_vars($obj);');
        $result = $publicVars($this);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    private function assignVariable(\Smarty $smarty)
    {
        $publicVars = create_function('$obj', 'return get_object_vars($obj);');
        $result = $publicVars($this);

        foreach ($result as $key => $var) {
            $smarty->assign($key, $var);
        }

        $data = json_encode($result);

        echo "<script>var view = $data</script>";
    }
}