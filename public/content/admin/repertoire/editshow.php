<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */


use resource\action\Base\Admin;

class editshow extends Admin
{
    public function onAction()
    {
        $showId = $this->getParam('showId');
        if(empty($showId)){
            $this->redirect('/admin/repertoire/repertoire');
        }


        if($this->hasPost()){
            $this->updateShow($showId);
            $this->view->saveCorrect = true;
        }

        $movies = $this->getMovies();
        $show = $this->getShow($showId);

        $this->view->movies = $movies;
        $this->view->show = $show;
    }

    public function getShow($showId)
    {
        $select = $this->db->select()
            ->from('show')
            ->where('id = ?', $showId)
        ;

        return $this->db->fetchRow($select);
    }

    public function getMovies()
    {
        $select = $this->db->select()
            ->from(['m' => 'movie'])
            ->join(['c' => 'category'], 'c.id = m.categoryId', ['category' => 'name'])
            ->where('m.active = 1');

        return $this->db->fetchAll($select);
    }

    public function updateShow($showId)
    {
        $post = $this->getPost();

        $this->db->update('show', ['movieId' => $post['movieId'], 'term' => $post['term']], 'id = '. $this->db->quote($showId));
    }
}