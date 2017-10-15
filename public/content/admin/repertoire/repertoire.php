<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use module\Action\Admin;

class repertoire extends Admin
{
    public function onAction()
    {
        $shows = $this->getRepertoire();
        $emptyPoster = base64_encode(file_get_contents('images/emptyPoster.jpg'));

        $this->view->emptyPoster = $emptyPoster;
        $this->view->shows = $shows;
    }

    public function getRepertoire()
    {
        $select = $this->db->select()
            ->from(['s' => 'show'])
            ->join(['m' => 'movie'], 's.movieId = m.id',['title','poster','duration'])
            ->where('s.active = 1')
            ->where('s.term > NOW()')
            ->order('s.term')
        ;

        return $this->db->fetchAll($select);
    }
}