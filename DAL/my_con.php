<?php

class my_con {

    public function my_con() {
        //this connectin for the local computer server, just uncommit it when needed.
        $con = new mysqli('localhost', 'root', '', 'eventsnotify');
        //this connectin for the server, just uncommit it when needed.   
        //$con = new mysqli('localhost', 'root', 'Y9ts3G2CPSqkgZTB', 'eventsnotify');
        mysqli_query($con, "SET NAMES 'utf8'");
        mysqli_query($con, 'SET CHARACTER SET utf8');
        return $con;
    }

}
