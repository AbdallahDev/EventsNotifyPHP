<?php

define('API_ACCESS_KEY', 'AAAAysijQG4:APA91bEVna5UC6cvLu8zFogm5m2F0GMCgK7LQhyaUpPuS840I6nCKIeytCtlvssjB6Vhsahc1cVZBnhtR73ZYD0lsa8urcdoqwc8ssXmwY-hJdFZgkV9UYIjGgxPL9yACi7FWBP0LOTk');

send_notification(nl2br("body"), "name"
        , "cA2UX7eghZc:APA91bHFj3hXLPGoq9vifaS9_09OeQmfcC7q5rykqZRjteJs3XP6JUNrJFQQNj0Wx5OhYZ_h8ehV36DhBaeBvW0vTM3Ndu62NBH4O52tcOZhQHPdbXW_5FUr9Kcg8zL79njkRl2nOjKR");

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
