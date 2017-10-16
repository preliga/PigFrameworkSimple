<?php

use \resource\action\Base;

class index extends Base
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
            ->join(['s' => 'show'], 's.movieId = m.id AND s.term >= NOW() AND s.term <= DATE_ADD(NOW(), INTERVAL 7 DAY)', [])
            ->where('m.active = 1')
            ->group('m.id');

        return $this->db->fetchAll($select);
    }
}
