<?php

include_once '../../DAL/my_db.php';

//this class to make modifications on the user_token table.
class device_token extends my_db {

    function store_device_token($device_token) {
        /* here i'll store the device_token in the table, and i'll get the value 
          from the url */
        $this->mod_data("INSERT INTO `device_token`(`device_token`) VALUES (?)"
                , 's', array(&$device_token));
    }

}
