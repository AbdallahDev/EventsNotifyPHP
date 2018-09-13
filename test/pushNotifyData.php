<?php

//this api access for the firebase server to send notification.
define('API_ACCESS_KEY', 'AAAAysijQG4:APA91bEVna5UC6cvLu8zFogm5m2F0GMCgK7LQhyaUpPuS840I6nCKIeytCtlvssjB6Vhsahc1cVZBnhtR73ZYD0lsa8urcdoqwc8ssXmwY-hJdFZgkV9UYIjGgxPL9yACi7FWBP0LOTk');

// Create connection
//this connectin for the local computer server, just uncommit it when needed.
$con = new mysqli('localhost', 'root', '', 'eventsnotify');
//this connectin for the real server, just uncommit it when needed.
//$con = new mysqli('localhost', 'root', 'Y9ts3G2CPSqkgZTB', 'eventsnotify');
mysqli_query($con, "SET NAMES 'utf8'");
mysqli_query($con, 'SET CHARACTER SET utf8');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} else {
    echo 'yes<br>';
}

$st = $con->prepare("SELECT notify_user_token FROM `notify_user`");
$st->execute();
$rs = $st->get_result();
while ($row = $rs->fetch_assoc()) {
    send_notification("اجتماع لجنة العمل", $row['notify_user_token']);
    echo $row['notify_user_token'];
}

function send_notification($subject, $token) {

    //   $registrationIds = ;
#prep the bundle
    $msg = array
        (
        'bodymsg' => 'body msg',
        'titlemsg' => 'title msg',
    );

    $data = array(
        'body' => $subject,
        'title' => 'اجتماع لجنة',
    );

    $fields = array
        (
        'to' => $token,
        'notification' => $msg,
        'data' => $data
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
