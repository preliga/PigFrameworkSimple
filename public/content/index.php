<?php

use resource\action\Base;
use resource\orm\Show;

class index extends Base
{

    public function onAction()
    {
        $shows = Show::getInstance();

        $movies = $shows->find(['s.term <= DATE_ADD(NOW(), INTERVAL 7 DAY)'], null, 'm.id')->getArray();

        $emptyPoster = base64_encode(file_get_contents('images/emptyPoster.jpg'));

        $this->view->emptyPoster = $emptyPoster;
        $this->view->movies = $movies;
    }

//    public function getMovies()
//    {
//        $select = $this->db->select()
//            ->from(['m' => 'movie'])
//            ->join(['s' => 'show'], 's.movieId = m.id AND s.term >= NOW() AND s.term <= DATE_ADD(NOW(), INTERVAL 7 DAY)', [])
//            ->where('m.active = 1')
//            ->group('m.id');
//
//        return $this->db->fetchAll($select);
//    }
}
