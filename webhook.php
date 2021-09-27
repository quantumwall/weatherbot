<?php
    require_once 'query.php';
    require_once 'weather.php';
    
    function getWindDirection ($direction) {
        //возвращает словесное описание направления ветра
        if (($direction >= 0 and $direction <= 10) or
                ($direction > 170 and $direction <= 180)) {
                $wind_direction = "северный";
            } elseif ($direction > 10 and $direction <= 30) {
                $wind_direction = "северо-восточный";
            } elseif ($direction > 30 and $direction <= 55) {
                $wind_direction = "восточный";
            } elseif ($direction > 55 and $direction <= 80) {
                $wind_direction = "юго-восточный";
            } elseif ($direction > 80 and $direction <= 100) {
                $wind_direction = "южный";
            } elseif ($direction > 100 and $direction <= 135) {
                $wind_direction = "юго-западный";
            } elseif ($direction > 135 and $direction <= 155) {
                $wind_direction = "западный";
            } elseif ($direction > 155 and $direction <= 170) {
                $wind_direction = "северо-западный";
            } else {
                $wind_direction = "неизвестно";
            }
        return $wind_direction;
    }
    
    function hPaTOmmHg ($hPa) {
        //конвертирует значение давление в гектопаскалях 
        //в миллиметры ртутного столба и возвращает значение
        return $hPa * 0.75;
    }
    
    $update = json_decode(file_get_contents('php://input'), true);
    $chat_id = $update['message']['chat']['id'];
    $username = $update['message']['from']['first_name'];
    $msg = $update['message']['text'];
    $dt = date('d-m-Y H:i:s', time()+10800);
    $message = "Неизвестная команда.\nДля вывода списка доступных команд набери /help\n";
    $client = new TelegramQuery(BOT_URL, BOT_TOKEN);
    
    switch (strtolower(ltrim($msg, "/"))) {
        case "start":
            $message = "Привет $username!\nЭто бот, предоставляющий сведения о текущей погоде или погоде на сегодняшний день.
Для справки набери /help\n";
            break;
        case "help":
            $message = "/start - Приветственное сообщение
/current - Погода на данный момент
/daily - Погода на сегодняшний день
/help - Спискок команд(эта справка)\n";
            break;
        case "current":
            list('description' => $desc,'temp' => $temp,'temp_feels_like' => $temp_feels_like,
            'pressure' => $pressure, 'current_humidity' => $current_humidity,
            'current_wind_speed' => $current_wind_speed, 'current_wind_direction' => $current_wind_direction) = $current_weather;
            
            $current_wind_direction = getWindDirection($current_wind_direction);
            $message = "Сейчас в Торбеево $desc 
$temp градусов 
ощущается как $temp_feels_like градусов 
ветер $current_wind_direction $current_wind_speed м/с 
давление " . hPaTOmmHg($pressure) . " мм.рт.ст. 
влажность $current_humidity %\n";
    }
    
    $client->sendMessage($chat_id, $message);
    
    file_put_contents("log.txt", "[$dt] chat_id => $chat_id\n", FILE_APPEND);
    file_put_contents("log.txt", "[$dt] username => $username\n", FILE_APPEND);
    file_put_contents("log.txt", "[$dt] message => $msg\n", FILE_APPEND);
