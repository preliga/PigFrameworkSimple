<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use resource\action\Base\Admin;
use resource\orm\{
    Movie, Show
};

class addshow extends Admin
{
    public function onAction()
    {
        $show = Show::createRecord();

        $show = Show::findOne([
            's.id = ?' => 1
        ]);

        $show->title = 'Piraci';

        $show->save();

        echo "<pre>";
        print_r($show->getArray());
        echo "</pre>";
        die();
//
//        die(var_dump($show));
//        $movies = $movies = Movie::find()->getArray();
//
//        $this->view->movies = $movies;
//
//        if ($this->hasPost()) {
//            $this->saveShow();
//            $this->view->saveCorrect = true;
//        }
    }

//    public function getMovies()
//    {
//        $select = $this->db->select()
//            ->from(['m' => 'movie'])
//            ->join(['c' => 'category'], 'c.id = m.categoryId', ['category' => 'name'])
//            ->where('m.active = 1');
//
//        return $this->db->fetchAll($select);
//    }

    public function saveShow()
    {
        $post = $this->getPost();

        $show = Show::createRecord();

        die(var_dump($show));

        $this->db->insert('show',['movieId' => $post['movieId'], 'term' => $post['term']]);
    }
}