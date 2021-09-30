<?php
    require_once "init_config.php";
    $params = ['lat' => '54.05',
                'lon' => '43.15',
                'lang' => 'ru',
                'units' => 'metric',
                'mode' => 'json',
                'appid' => WEATHER_TOKEN,
                'exclude' => 'minutely,hourly'];
    $url = WEATHER_URL."?".http_build_query($params);
    $result = json_decode(file_get_contents($url), true);
    //print "<pre>";
    //print_r($result);
    //print "</pre>";
    $city = "Торбеево";

    //создать массив погоды на день
    $daily = $result['daily'][0];
    $daily_weather = ['city' => $city,
                        'description' => $daily['weather'][0]['description'],
                        'temp' => $daily['temp']['day'],
                        'temp_feels_like' => $daily['feels_like']['day'],
                        'pressure' => $daily['pressure'],
                        'humidity' => $daily['humidity'],
                        'wind_speed' => $daily['wind_speed'],
                        'wind_direction' => $daily['wind_deg']];
    unset($daily);

    //создать массив погоды на текущий момент
    $current = $result['current'];
    $current_weather = ['city' => $city,
                        'description' => $current['weather'][0]['description'],
                        'temp' => $current['temp'],
                        'temp_feels_like' => $current['feels_like'],
                        'pressure' => $current['pressure'],
                        'humidity' => $current['humidity'],
                        'wind_speed' => $current['wind_speed'],
                        'wind_direction' => $current['wind_deg']];
    unset($current);


    print "<pre>";
    print_r($current_weather);
    print "</pre>";

    print "<pre>";
    print_r($daily_weather);
    print "</pre>";
