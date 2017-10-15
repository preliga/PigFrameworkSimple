<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use module\Action\Admin;

class removemovie extends Admin
{

    public function onAction()
    {
        $movieId = $this->getParam('movieId');

        $this->deactivateMovie($movieId);

        $this->redirect('/admin/movies/movies');
    }

    public function deactivateMovie($movieId)
    {
        $this->db->update('movie', ['active' => 0], 'id = ' . $this->db->quote($movieId));
    }
}