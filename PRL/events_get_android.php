<?php

//include events class
include_once '../BLL/events.php';

//bellow i get the events to view them in the android app
$events_android = new events();
//here i check for the committee url value, if it's 0 that means that the user
//decided to view all the committees events.
$events_array = array();
if ($_GET['committee'] == 0) {
    $rs_events_android = $events_android->events_get_android();
    while ($row_events_android = $rs_events_android->fetch_assoc()) {
        array_push($events_array, $row_events_android);
    }
}
//here i'll return the events just for specific committees
else {
    $rs_events_android = $events_android->events_get_by_committee_android($_GET['committee']);
    while ($row_events_android = $rs_events_android->fetch_assoc()) {
        array_push($events_array, $row_events_android);
    }
}
echo json_encode($events_array);
