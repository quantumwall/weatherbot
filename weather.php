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
    $current_weather_desc = $result['current']['weather'][0]['description'];
    $current_temp = $result['current']['temp'];
    $current_temp_feels_like = $result['current']['feels_like'];
    $current_pressure = $result['current']['pressure'];
    $current_humidity = $result['current']['humidity'];
    $current_wind_speed = $result['current']['wind_speed'];
    $current_wind_direction = $result['current']['wind_deg'];
    $current_weather = ['decription' => $current_weather_desc,
                        'temp' => $current_temp,
                        'temp_feels_like' => $current_temp_feels_like,
                        'pressure' => $current_pressure,
                        'current_humidity' => $current_humidity,
                        'current_wind_speed' => $current_wind_speed,
                        'current_wind_direction' => $current_wind_direction];
    print serialize($current_weather);
    /*print "<pre>";
    print_r($current_weather);
    print "</pre>";*/
    //print "$city $current_weather_desc $current_temp $current_temp_feels_like $current_pressure $current_humidity $current_wind_speed $current_wind_direction";
    //то же самое, но для всего дня
