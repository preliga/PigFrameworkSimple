<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use library\Pig\Session;
use module\Action\Admin;

class logout extends Admin
{
    public function onAction()
    {
        $this->db->update('admin',['session' => null], 'id = '. $this->db->quote($this->userAdmin['id']));

        Session::set('session', null);

        $this->redirect('/admin/login');
    }
}