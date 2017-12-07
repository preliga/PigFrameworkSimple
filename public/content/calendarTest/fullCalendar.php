<?php

use resource\action\Base;

class fullCalendar extends Base
{
    public function init()
    {
        parent::init();
        $this->addJS('/scripts/lib/fullCalendar/moment.min.js');
        $this->addJS('/scripts/lib/fullCalendar/fullcalendar.min.js');
    }

    public function onAction()
    {

    }

}
