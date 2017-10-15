<?php

/**
 * Created by PhpStorm.
 * User: Piotr
 */

use library\Pig\Action;

class bookTickets extends Action
{
    public function onAction()
    {
        $showId = $this->getParam('showId');

        if (empty($showId)) {
            $this->redirect('/');
        }

        $this->saveTickets($showId);

        $this->redirect("/admin/repertoire/seats?showId=$showId");
    }

    public function resetSeats($showId)
    {
        $this->db->update('seat', ['active' => 0], 'showId = '. $this->db->quote($showId));
    }

    public function saveTickets($showId)
    {
        $this->resetSeats($showId);
        $dataToInsert = $this->prepareDateToInsert($showId);

        foreach ($dataToInsert as $data) {
            $this->db->insert('seat', $data);
        }
    }

    public function prepareDateToInsert($showId)
    {
        $post = $this->getPost();

        $dataToInsert = [];

        foreach ($post as $seatNr => $value) {
            if (is_numeric($seatNr) && $seatNr > 0 && $seatNr <= 40) {
                $dataToInsert[] = [
                    'showId' => $showId,
                    'seatNr' => $seatNr
                ];
            }
        }

        return $dataToInsert;
    }

}