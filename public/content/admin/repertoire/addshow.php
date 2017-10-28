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
        Show::getInstance()->test();

        $movies = Movie::getInstance()->find()->getArray();

        $this->view->movies = $movies;

        if ($this->hasPost()) {
            $this->saveShow();
            $this->view->saveCorrect = true;
        }
    }

    public function saveShow()
    {
        $post = $this->getPost();

        $show = Show::getInstance()->createRecord();

        $show->movieId = $post['movieId'];
        $show->term = $post['term'];

        $show->save(null,['show']);
    }
}