<?php

include '../DAL/my_con.php';

$statement = $con->prepare("INSERT INTO `notify_user`(`notify_user_token`) VALUES (?)");

$statement->bind_param("s", $_GET['token']);

$statement->execute();
