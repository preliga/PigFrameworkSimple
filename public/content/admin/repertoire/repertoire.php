<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use resource\action\Base\Admin;
use resource\orm\Show;

class repertoire extends Admin
{
    public function onAction()
    {
//        $shows = $this->getRepertoire();
        $shows = Show::getInstance()->find([
            's.term > NOW()'
        ])->getArray();

        $emptyPoster = base64_encode(file_get_contents('images/emptyPoster.jpg'));

        $this->view->emptyPoster = $emptyPoster;
        $this->view->shows = $shows;
    }

//    public function getRepertoire()
//    {
//        $select = $this->db->select()
//            ->from(['s' => 'show'])
//            ->join(['m' => 'movie'], 's.movieId = m.id',['title','poster','duration'])
//            ->where('s.active = 1')
//            ->where('s.term > NOW()')
//            ->order('s.term')
//        ;
//
//        return $this->db->fetchAll($select);
//    }
}