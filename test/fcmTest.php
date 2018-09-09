<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Kreait\Firebase\Messaging\CloudMessage;

$deviceToken = 'dZ-N8q8lD2Q:APA91bGQHJdTPnz8wSsT1ni_ymWj6_Q4fpesWunVy9hzAbgcoBuGyklFot9FGxQMNkKL4QrFWxacUQqLxkYYqes9dVCI1ggbb1qMM5j6PbKuYlqVYfChYrfa8aBNSLqqNnBStKUfBQHm';

$message = CloudMessage::withTarget('token', $deviceToken)
    ->withNotification($notification) // optional
    ->withData($data) // optional
;

$message = CloudMessage::fromArray([
    'token' => $deviceToken,
    'notification' => [/* Notification data as array */], // optional
    'data' => [/* data array */], // optional
]);

$messaging->send($message);