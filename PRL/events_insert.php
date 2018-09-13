<?php

include_once 'include/check_session.php';
include_once '../BLL/events.php';

//bellow i'll check if the event appointment is set in the event appointemnt 
//textbox, to view it in the live screen instead of the event time.
if (isset($_POST['event_appointment']) && !empty(trim($_POST['event_appointment']))) {
    $event_appointment = $_POST['event_appointment'];
    //bellow i set the value of the time from the form to the event_time 
    //variable and increase it with one second so it can come on the live screen 
    //after the event that it should come after it, because sometime multiple
    //events has the same exact appoitment time.
    $event_time = date("H:i:s", strtotime($_POST['time']) + 1);
} else {//here when the event appointment is empty
    //here the event appointment will be empty
    $event_appointment = $_POST['event_appointment'];
    //here i set the value of the time from the form to the event_time variable 
    //as it's, because the events appointment has not set, so i won't need the 
    //increase the event time by one second
    $event_time = $_POST['time'];
}

if (isset($_POST['event_status'])) {
    $event_status = $_POST['event_status'];
} else {
    $event_status = 0;
}
//here i check if the hall has been choosed
if ((isset($_POST['hall'])) && !empty(trim($_POST['hall']))) {
    $hall_id = $_POST['hall'];
    $event_place = '';
} elseif (isset($_POST['event_place_textbox'])) {
    //here i check if the hall hasn't been choosen, instead the text box filled 
    //with the place of the event
    if (!empty(trim($_POST['event_place_textbox']))) {
        $event_place = $_POST['event_place_textbox'];
        $hall_id = 0;
    } else {
        $event_place = '';
        $hall_id = 0;
    }
}
//bellow i'll check if the user choosed the event entity name (like committee) 
//from the dropdown menu or typed it's name in the textbox
//here i check the event entity has been choosed form the dropdown menu
if (isset($_POST['committee']) && !empty(trim($_POST['committee']))) {
    //here i choose the event entity name that choosen from the dropdown to be 
    //inserted
    $event_entity = $_POST['committee'];
    //here i make the event entity name empty, because the name choosed from the 
    //dropdown
    $event_entity_name = '';
} else {
    //here i choose the event entity name that typed in the event entity textbox 
    //to be inserted
    $event_entity_name = $_POST['event_entity_name'];
    //here i check if the directorate of the user is legislate affiars with 
    //value 2, to store 2 in the committee id
    if ($_SESSION['directorate'] == 2) {
        //here i make the event entity to 2, because the name typed in the 
        //textbox
        $event_entity = 2;
    }
    //here i check if the directorate of the user is general affairs with 
    //value 3, to store 3 in the committee id
    elseif ($_SESSION['directorate'] == 3) {
        //here i make the event entity to 3, because the name typed in the textbox
        $event_entity = 3;
    }
    //here i check if the directorate of the user is blocs with value 4, 
    //to store 4 in the entity event id
    elseif ($_SESSION['directorate'] == 4) {
        //here i make the event entity to 4, because the name typed in the textbox
        $event_entity = 4; 
    }
}

//bellow is all the code related the push notification
//and i but it down here so i can get the variables from the form with conditions
//applied to it above, like the appointment time and event date.
//
//here i'll send notification with the event details
//bellow i'll select the committee name to send it with the notificaiton
include_once '../BLL/committees.php';
$committee = new committees();
$rs_committee = $committee->committee_get($_POST['committee']);
$row_committee = $rs_committee->fetch_assoc();
$committee_name = $row_committee['committee_name'];

//this api for the firebase server, this api has been taken from the firebase
//console to send push notification
//$registrationIds = ;
define('API_ACCESS_KEY', 'AAAAysijQG4:APA91bEVna5UC6cvLu8zFogm5m2F0GMCgK7LQhyaUpPuS840I6nCKIeytCtlvssjB6Vhsahc1cVZBnhtR73ZYD0lsa8urcdoqwc8ssXmwY-hJdFZgkV9UYIjGgxPL9yACi7FWBP0LOTk');

//bellow i'll select the all the users tokens in the db to send them notifications
include_once '../BLL/notify_users.php';
$notify_user = new notify_user();
$rs_notify_user = $notify_user->get_all_users_token();
while ($row_notify_user = $rs_notify_user->fetch_assoc()) {
    //this variable to store all the needed information for the notification
    //like the event subject and date and time.
    $notificaiton_body = "<b>الموضوع:</b> " . $_POST['subject'] . "<br>"
            . "<br>"
            . "<b>التاريخ:</b> " . $_POST['event_date'] . "<br>"
            . "<b>الوقت:</b> " . $event_time;
    send_notification(nl2br($notificaiton_body), $committee_name
            , $row_notify_user['notify_user_token']);
}

//this function to send the push notification
function send_notification($notificaiton_body, $event, $token) {
#prep the bundle
    $msg = array
        (
        'body' => $notificaiton_body,
        'title' => $event,
    );
    $fields = array
        (
        'to' => $token,
        'notification' => $msg
    );

    $headers = array
        (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

#Send Reponse To FireBase Server	
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    echo $result;
    curl_close($ch);
}

//bellow is the code related to store the event in the db.
$event1 = new events();
$event1->insert_event($event_entity, $event_entity_name, $event_time, $event_appointment, $hall_id, $event_place, nl2br($_POST['subject']), $_POST['event_date'], $event_status, $_SESSION['directorate'], $_SESSION['user_id']);

header('location: events_preview_current_future.php');
