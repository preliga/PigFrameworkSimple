<?php


use resource\action\Base;

class movie extends Base
{
    public function onAction()
    {
        $movieId = $this->getParam('movieId');

        if(empty($movieId)){
            $this->redirect('/', [], false, "Not found param 'movieId'");
        }

        $movie = $this->getMovie($movieId);

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
}