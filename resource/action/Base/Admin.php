<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 */
namespace resource\action\Base;

use library\PigFramework\model\Session;
use resource\action\Base;

abstract class Admin extends Base
{
    /**
     * @var array
     */
    protected $userAdmin;

    /**
     *
     */
    public function permissionBase()
    {
        $session = Session::get('session');

        if(empty($session)){
            $this->redirect('/admin/login');
        }

        $select = $this->db->select()
            ->from('admin', ['id', 'name', 'lastName', 'login'])
            ->where('session = ?', $session)
        ;

        $admin = $this->db->fetchRow($select);

        if(empty($admin)){
            $this->redirect('/admin/login');
        }

        $this->userAdmin = $admin;
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->view->setTemplate('admin');
    }
}