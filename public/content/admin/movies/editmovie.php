<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use resource\action\Base\Admin;

class editmovie extends Admin
{
    public function onAction()
    {
        $movieId = $this->getParam('movieId');

        if (empty($movieId)) {
            $this->redirect('/admin/movies/movies');
        }

        if ($this->hasPost()) {
            $this->updateMovie($movieId);
            $this->view->saveCorrect = true;
        }

        $movie = $this->getMovie($movieId);

        if (empty($movie)) {
            $this->redirect('/admin/movies/movies');
        }

        $category = $this->getCategory();

        $this->view->category = $category;
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

    public function getCategory()
    {
        $select = $this->db->select()
            ->from('category');

        return $this->db->fetchAll($select);
    }

    public function updateMovie($movieId)
    {
        $data = $this->getPost();

        $newData =
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'trailer' => $data['trailer'],
                'categoryId' => $data['category'],
                'duration' => $data['duration']
            ];

        if (!empty($_FILES['poster']['tmp_name'])) {
            $newData['poster'] = base64_encode(file_get_contents($_FILES['poster']['tmp_name']));
        }

        $this->db->update('movie', $newData, 'id = ' . $this->db->quote($movieId));
    }
}