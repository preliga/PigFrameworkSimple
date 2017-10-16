<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use resource\action\Base\Admin;

class seats extends Admin
{
    public function init()
    {
        parent::init();
        $this->view->setTemplate('standard');
    }

    public function onAction()
    {
        $showId = $this->getParam('showId');

        if (empty($showId)) {
            $this->redirect('/');
        }

        $show = $this->getShow($showId);

        if (empty($show)) {
            $this->redirect('/');
        }

        $seats = $this->getSeats($showId);


        $emptyPoster = base64_encode(file_get_contents('images/emptyPoster.jpg'));
        $this->view->emptyPoster = $emptyPoster;
        $this->view->show = $show;
        $this->view->seats = $seats;
    }

    public function getShow($showId)
    {
        $select = $this->db->select()
            ->from(['s' => 'show'], ['id', 'term'])
            ->join(['m' => 'movie'], 'm.id = s.movieId', ['title', 'duration', 'poster', 'trailer'])
            ->join(['c' => 'category'], 'c.id = m.categoryId', ['category' => 'name'])
            ->where('s.id = ?', $showId)
            ->where('s.active = 1', $showId);

        return $this->db->fetchRow($select);
    }

    public function getSeats($showId)
    {
        $select = $this->db->select()
            ->from('seat', ['seatNr'])
            ->where('showId = ?', $showId)
            ->where('active = 1');


        return $this->db->fetchAssoc($select);
    }
}