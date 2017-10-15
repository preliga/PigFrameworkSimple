<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use library\Pig\model\Session;
use module\Action\Base;

class login extends Base
{
    public function permission()
    {
        $session = Session::get('session');
        if (!empty($session)) {
            $select = $this->db->select()
                ->from('admin', ['name', 'lastName', 'login'])
                ->where('session = ?', $session);

            $admin = $this->db->fetchOne($select);

            if (!empty($admin)) {
                $this->redirect('/admin/movies/movies');
            }
        }
    }

    public function onAction()
    {
        if ($this->hasPost()) {
            if ($this->signIn()) {
                $this->redirect('/admin/movies/movies');
            } else {
                $this->view->error = 'Login or password is incorrect.';
            }
        }
    }

    private function signIn()
    {
        $login = $this->getPost('login');
        $password = $this->getPost('password');

        if (!empty($login) && !empty($password)) {
            $select = $this->db->select()
                ->from('admin')
                ->where('login = ?', $login)
                ->where('password = ?', sha1($password));

            $userAdmin = $this->db->fetchRow($select);

            if (!empty($userAdmin)) {
                $session = sha1(date('YmdHis') . rand(0, 2000000));

                $this->db->update('admin', ['session' => $session], 'id = ' . $this->db->quote($userAdmin['id']));

                Session::set('session', $session);

                return true;
            }
        }


        return false;
    }
}