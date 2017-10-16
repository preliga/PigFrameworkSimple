<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use resource\action\Base\Admin;

class removeshow extends Admin
{

    public function onAction()
    {
        $showId = $this->getParam('showId');

        $this->deactivateShow($showId);

        $this->redirect('/admin/repertoire/repertoire');
    }

    public function deactivateShow($showId)
    {
        $this->db->update('show',['active' => 0], 'id = '. $this->db->quote($showId));
    }
}