<?php

include_once '../../DAL/my_db.php';

class user_token extends my_db {

    function store_user_token($user_token) {
        $this->mod_data("INSERT INTO `user_token`(`user_token`) VALUES (?)", 's'
                , array(&$user_token));
    }

}
