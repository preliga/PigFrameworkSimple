<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use resource\action\Base\Admin;

class movies extends Admin
{
    public function onAction()
    {
        $movies = $this->getMovies();
        $emptyPoster = base64_encode(file_get_contents('images/emptyPoster.jpg'));

        $this->view->emptyPoster = $emptyPoster;
        $this->view->movies = $movies;
    }

    public function getMovies()
    {
        $select = $this->db->select()
            ->from(['m' => 'movie'])
            ->join(['c' => 'category'], 'c.id = m.categoryId', ['category' => 'name'])
            ->where('m.active = 1');

        return $this->db->fetchAll($select);
    }
}