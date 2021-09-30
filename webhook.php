<?php
    require_once 'query.php';
    require_once 'init_config.php';

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
    //получить сообщение от пользователя
    //взять chat_id, имя пользователя и его сообщение
    $update = json_decode(file_get_contents('php://input'), true);
    $chat_id = $update['message']['chat']['id'];
    $username = $update['message']['from']['first_name'];
    $msg = $update['message']['text'];
    $dt = date('d-m-Y H:i:s', time()+10800);
    $message = "Неизвестная команда.\nДля вывода списка доступных команд набери /help\n";


    $bot = new TelegramQuery(BOT_URL, BOT_TOKEN);

    switch (strtolower(ltrim($msg, "/"))) {
        case "start":
            $message = "Привет $username!\nЭто бот, предоставляющий сведения о текущей погоде или погоде на сегодняшний день.
Для справки набери /help\n";
            break;
        case "help":
            $message = "/start - Приветственное сообщение
/current - Погода на данный момент
/today - Погода на сегодняшний день
/help - Спискок команд(эта справка)\n";
            break;
        case "current":
            require_once 'weather.php';
            list('city' => $city, 'description' => $desc,'temp' => $temp,'temp_feels_like' => $temp_feels_like,
            'pressure' => $pressure, 'humidity' => $humidity,
            'wind_speed' => $wind_speed, 'wind_direction' => $wind_direction) = $current_weather;
            $wind_direction = getWindDirection($wind_direction);
            $message = "Сейчас в $city $desc, ".round($temp, 1)." градусов
ощущается как ".round($temp_feels_like, 1)." градусов
ветер $wind_direction $wind_speed м/с
давление " . round(hPaTOmmHg($pressure), 1) . " мм.рт.ст.
влажность $humidity %\n";
            break;
        case "today":
            require_once 'weather.php';
            list('city' => $city, 'description' => $desc,'temp' => $temp, 'temp_feels_like' => $temp_feels_like,
            'pressure' => $pressure, 'humidity' => $humidity,
            'wind_speed' => $wind_speed, 'wind_direction' => $wind_direction) = $daily_weather;
            $wind_direction = getWindDirection($wind_direction);
            $message = "Сегодня в $city $desc, ".round($temp, 1)." градусов
ощущается как ".round($temp_feels_like, 1)." градусов
ветер $wind_direction $wind_speed м/с
давление " . round(hPaTOmmHg($pressure), 1) . " мм.рт.ст.
влажность $humidity %\n";
    }

    $bot->sendMessage($chat_id, $message);
