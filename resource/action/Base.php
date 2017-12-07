<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 */

namespace resource\action;

use library\PigFramework\action\Action;
use library\PigFramework\model\Config;
use library\PigFramework\model\Db;
use Zend_Db_Adapter_Mysqli;

abstract class Base extends Action
{
    /**
     * @var Zend_Db_Adapter_Mysqli
     */
    protected $db;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->definedJS();
        $this->definedCSS();

        $config = Config::getInstance()->getConfig('db');
        $db = Db::getInstance($config['cinema'], 'cinema');
        $this->db = $db->getDb();
    }

    /**
     *
     */
    private function definedJS()
    {
        $this->addJS('/scripts/lib/jquery/jquery.min.js');
        $this->addJS('/scripts/lib/datetimepicker/jquery.datetimepicker.full.min.js');
        $this->addJS('/scripts/lib/popper/popper.min.js');
        $this->addJS('/scripts/lib/bootstrap/js/bootstrap.min.js');
        $this->addJS('/scripts/lib/bootstrap/js/bootstrap.min.js');
    }

    /**
     *
     */
    private function definedCSS()
    {
        $this->addCSS('/scripts/lib/bootstrap/css/bootstrap.min.css');
        $this->addCSS('https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800');
        $this->addCSS('https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic');
        $this->addCSS('/scripts/lib/css/business-casual.css');
        $this->addCSS('/scripts/lib/font-awesome-4.7.0/css/font-awesome.min.css');
        $this->addCSS('/scripts/lib/datetimepicker/jquery.datetimepicker.min.css');
        $this->addCSS('/scripts/app/css/style.css');
    }
}