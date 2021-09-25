<?php
    require_once 'query.php';
    require_once 'weather.php';
    
    $update = json_decode(file_get_contents('php://input'), true);
    $chat_id = $update['message']['chat']['id'];
    $username = $update['message']['from']['first_name'];
    $msg = $update['message']['text'];
    $current_weather = serialize($current_weather);
    file_put_contents("log.txt", "weather => $current_weather\n", FILE_APPEND);die;
    
    $client = new TelegramQuery(BOT_URL, BOT_TOKEN);
    $client->sendMessage($chat_id, serialize($current_weather));
    
    /*file_put_contents("log.txt", "chat_id => $chat_id\n", FILE_APPEND);
    file_put_contents("log.txt", "username => $username\n", FILE_APPEND);
    file_put_contents("log.txt", "message => $msg\n", FILE_APPEND);*/

    //$update = serialize($update);
    //file_put_contents("log.txt", $update, FILE_APPEND);
