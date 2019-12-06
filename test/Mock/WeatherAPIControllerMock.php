<?php

// namespace Anax\Weather;

// /**
//  *
// * Mockclass for WeatherApiController
// */
// class WeatherApiControllerMock extends WeatherAPIController
// {
//     /**
//      * Get weather
//      * Today, and next 7 days or
//      * Previous days
//      *
//      * @return array
//      */
//     public function getWeather($location, $days = null)
//     {
//         $CurlModel = $this->di->get("curl");
//         $WeatherModel = new WeatherModelMock;
//         $WeatherModel->setCurl($CurlModel);
        
//         $weatherInfo = [];
//         $convertedLocation = $WeatherModel->convertLocation($location);
//         ini_set('serialize_precision', -1);
        
//         if ($convertedLocation["match"] && $days !== null) {
//             $weatherInfo = $WeatherModel->getWeatherMulti($convertedLocation["latitude"], $convertedLocation["longitude"], $days);
//         } else if ($convertedLocation["match"]) {
//             $weatherInfo = $WeatherModel->getWeather($convertedLocation["latitude"], $convertedLocation["longitude"], $days);
//         }
//         return [[
//             "match" => $convertedLocation["match"],
//             "location" => $convertedLocation,
//             "weatherinfo" => $weatherInfo
//         ]];
//     }
// }
