<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 */
namespace module\Action;

use library\Pig\model\Session;

class Admin extends Base
{
    protected $userAdmin;

    public function permission()
    {
        $session = Session::get('session');

        if(empty($session)){
            $this->redirect('/admin/login');
        }

        $select = $this->db->select()
            ->from('admin', ['name', 'lastName', 'login'])
            ->where('session = ?', $session)
        ;

        $admin = $this->db->fetchRow($select);

        if(empty($admin)){
            $this->redirect('/admin/login');
        }

        $this->userAdmin = $admin;
    }

    public function init()
    {
        parent::init();

        $this->view->setTemplate('admin');
    }
}