<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use library\PigOrm\Record;
use resource\action\Base\Admin;
use resource\orm\{
    Movie, Show
};

class addshow extends Admin
{
    public function onAction()
    {
        $movies = Movie::getInstance()->find();

        $this->view->movies = $movies->getArray();

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