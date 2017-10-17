<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace library\Pig\model;

class View
{
    /**
     * @var string
     */
    public $file;

    /**
     * @var bool
     */
    public $fileJsExist;

    /**
     * @var string
     */
    public $template;

    /**
     * @var array
     */
    public $path;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $message;

    /**
     * @var ScriptLoader
     */
    public $scriptLoader;

    public function __construct(string $file, string $template = 'standard')
    {
        $this->file = $file;
        $this->fileJsExist = file_exists("$this->file.js");

        $this->template = $template;

        $this->path = explode('/', $file);

        $this->status = "success";
        $this->message = "";

        $this->scriptLoader = new ScriptLoader();
    }

    public function setTemplate(string $template)
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

    public function prepareRequest(array $data = null)
    {
        if (empty($data)) {
            $publicVars = create_function('$obj', 'return get_object_vars($obj);');
            $data = $publicVars($this);
            unset($data['file']);
            unset($data['fileJsExist']);
            unset($data['template']);
            unset($data['path']);
            unset($data['status']);
            unset($data['message']);
        }


        header('Content-Type: application/json');
        echo json_encode(['data' => $data, 'status' => $this->status, 'message' => $this->message]);
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