<?php

include_once '../../DAL/my_db.php';

class events extends my_db {

    function get_events() {
        return $this->get_all_data("SELECT EVENTS.subject FROM `events`");
    }

}
