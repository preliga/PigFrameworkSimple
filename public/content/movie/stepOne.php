<?php


use resource\action\Base;

class stepOne extends Base
{
    public function onAction()
    {
        $movieId = $this->getParam('movieId');

        if (empty($movieId)) {
            $this->redirect('/', [], false, "Not found param 'movieId'");
        }

        $movie = $this->getMovie($movieId);


        if (empty($movie)) {
            $this->redirect('/', [], false, "Not found movie with id: '$movieId'");
        }

        $shows = $this->getRepertoire($movieId);

        if (empty($shows)) {
            $this->redirect('/', [], false, "Not found shows with movie with id: '$movieId'");
        }

        $emptyPoster = base64_encode(file_get_contents('images/emptyPoster.jpg'));


        $days = [];

        foreach ($shows as $show) {
            $date = new DateTime($show['term']);
            if (!in_array($date->format('Y-m-d'), $days)) {
                $days[] = $date->format('Y-m-d');
            }
        }

        $this->view->emptyPoster = $emptyPoster;
        $this->view->days = $days;
        $this->view->shows = $shows;
        $this->view->movie = $movie;
    }

    public function getMovie($movieId)
    {
        $select = $this->db->select()
            ->from(['m' => 'movie'])
            ->join(['c' => 'category'], 'c.id = m.categoryId', ['category' => 'name'])
            ->where('m.active = 1')
            ->where('m.id = ?', $movieId);

        return $this->db->fetchRow($select);
    }

    public function getRepertoire($movieId)
    {
        $select = $this->db->select()
            ->from(['s' => 'show'])
            ->join(['m' => 'movie'], 's.movieId = m.id', ['title', 'poster', 'duration'])
            ->where('s.active = 1')
            ->where('m.id = ?', $movieId)
            ->where('s.term >= NOW()')
            ->where('s.term <= DATE_ADD(NOW(), INTERVAL 7 DAY)')
            ->order('s.term');

        return $this->db->fetchAll($select);
    }
}