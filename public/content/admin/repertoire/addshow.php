<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use resource\action\Base\Admin;

class addshow extends Admin
{
    public function onAction()
    {
        $movies = $this->getMovies();

        $this->view->movies = $movies;

        if ($this->hasPost()) {
            $this->saveShow();
            $this->view->saveCorrect = true;
        }
    }

    public function getMovies()
    {
        $select = $this->db->select()
            ->from(['m' => 'movie'])
            ->join(['c' => 'category'], 'c.id = m.categoryId', ['category' => 'name'])
            ->where('m.active = 1');

        return $this->db->fetchAll($select);
    }

    public function saveShow()
    {
        $post = $this->getPost();

        $this->db->insert('show',['movieId' => $post['movieId'], 'term' => $post['term']]);
    }
}