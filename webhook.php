<?php
    
    $update = json_decode(file_get_contents('php://input'), true);
    $chat_id = $update['message']['chat']['id'];
    $username = $update['message']['from']['first_name'];
    $msg = $update['message']['text'];
    file_put_contents("log.txt", "chat_id => $chat_id\n", FILE_APPEND);
    file_put_contents("log.txt", "username => $username\n", FILE_APPEND);
    file_put_contents("log.txt", "message => $msg\n", FILE_APPEND);

    //$update = serialize($update);
    //file_put_contents("log.txt", $update, FILE_APPEND);
