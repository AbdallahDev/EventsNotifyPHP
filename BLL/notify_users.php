<?php

include_once '../DAL/my_db.php';

class notify_user extends my_db {

    public function get_all_users_token() {
        return $this->get_all_data('SELECT notify_user_token FROM `notify_user`');
    }

}
