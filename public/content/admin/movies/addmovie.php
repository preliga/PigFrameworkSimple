<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use resource\action\Base\Admin;

class addmovie extends Admin
{
    public function __construct($file)
    {
        parent::__construct($file);
    }

    public function onAction()
    {
        $category = $this->getCategory();

        $this->view->category = $category;

        if ($this->hasPost()) {
            $this->addMovie();
            $this->view->saveCorrect = true;
        }
    }

    public function addMovie()
    {
        $data = $this->getPost();

        $poster = "";
        if (!empty($_FILES['poster']['tmp_name'])) {
            $poster = base64_encode(file_get_contents($_FILES['poster']['tmp_name']));
        }

        $this->db->insert('movie',
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'trailer' => $data['trailer'],
                'categoryId' => $data['category'],
                'poster' => $poster,
                'duration' => $data['duration']
            ]
        );
    }

    public function getCategory()
    {
        $select = $this->db->select()
            ->from('category');

        return $this->db->fetchAll($select);
    }
}