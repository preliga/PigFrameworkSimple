<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use library\Pig\orm\Record;
use resource\action\Base\Admin;
use resource\orm\{
    Movie, Show
};

class addshow extends Admin
{
    public function onAction()
    {
        $movies = Movie::getInstance()->find();


        $x = $movies->filter(function(Record $record){
            return is_null($record->poster);
        });


        $x->addRecord(Movie::getInstance()->get(5),false);


//        $x->reload();
//        $y = $movies->marge($x);
        echo "<pre>";
        print_r($x->getArray());
        echo "</pre>";
        die();
        
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