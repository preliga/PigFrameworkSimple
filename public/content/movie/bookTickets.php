<?php

use library\PigFramework\model\Session;
use resource\action\Base;

class bookTickets extends Base
{
    public function onAction()
    {
        $showId = $this->getParam('showId');

        if (empty($showId)) {
            $this->redirect('/', [], false, "Not found param 'showId'");
        }

        $email = $this->getPost('email');
        if (empty($email)) {
            $this->redirect('/', [],false, "Not found post arg 'email'");
        }

        if (count($this->getPost()) < 2) {
            Session::set('bookTicketsError', 'Choose seats.');
            $this->redirect("/movie/stepTwo", ['showId' => $showId]);
        }

        $this->saveTickets($showId);

        $this->sendMail($email);

        Session::set('bookTicketsMessage', 'Booking was correct. <br> Mail was send.');

        $this->redirect("/movie/stepTwo", ['showId' => $showId]);
    }

    public function getSeats($showId)
    {
        $select = $this->db->select()
            ->from('seat', ['seatNr'])
            ->where('showId = ?', $showId)
            ->where('active = 1');

        return $this->db->fetchAssoc($select);
    }

    public function prepareDateToInsert($showId)
    {
        $seats = $this->getSeats($showId);
        $post = $this->getPost();

        $dataToInsert = [];

        foreach ($post as $seatNr => $value) {
            if (is_numeric($seatNr) && $seatNr > 0 && $seatNr <= 40 && !in_array($seatNr, $seats)) {
                $dataToInsert[] = [
                    'showId' => $showId,
                    'seatNr' => $seatNr
                ];
            }
        }

        return $dataToInsert;
    }

    public function saveTickets($showId)
    {
        $dataToInsert = $this->prepareDateToInsert($showId);

        foreach ($dataToInsert as $data) {
            $this->db->insert('seat', $data);
        }
    }

    public function sendMail($email)
    {
        $to = $email;
        $subject = 'Book Tickets';
        $messages = 'Seats have been booked.';

        $headers = 'Content-type: text/html; charset=utf-8';

        mail($to, $subject, $messages,$headers);
    }
}