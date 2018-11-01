<?php

include_once '../BLL/android/user_token.php';

$user_token = new user_token();
$user_token->store_user_token($_GET['userToken']);