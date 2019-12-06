<?php

// namespace Anax\Weather;

// /**
//  *
// * Mockclass for WeatherApiController
// */
// class WeatherControllerMock extends WeatherController
// {
//      /**
//      * This is the index method action, it handles:
//      * ANY METHOD mountpoint
//      * ANY METHOD mountpoint/
//      * ANY METHOD mountpoint/index
//      *
//      * @return string
//      */
//     public function indexAction()
//     {
//         $title = "Weather info";
//         $page = $this->di->get("page");

//         $CurlModel = $this->di->get("curl");
//         $WeatherModel = $this->di->get("weather");
//         $WeatherModel->setCurl($CurlModel);

//         $request = $this->di->get("request");

//         $page->add("weather/form-text-weather", []);
//         $page->add("weather/clear", []);

//         if ($this->di->get("request")->hasGet("location")) {
//             $convertedLocation = $WeatherModel->convertLocation($request->getGet("location"));
//             if ($convertedLocation["match"]) {
//                 $weatherInfo["location"] = $convertedLocation;
//                 $weatherInfo["weather"] = $WeatherModel->getWeather($convertedLocation["latitude"], $convertedLocation["longitude"]);
//                 $weatherInfoPast = $WeatherModel->getWeatherMulti($convertedLocation["latitude"], $convertedLocation["longitude"], 30);

//                 $page->add("weather/location", ["location" => $weatherInfo["location"]]);
//                 $page->add("weather/result", ["weatherinfo" => $weatherInfo]);
//                 $page->add("weather/resultpast", ["weatherinfo" => $weatherInfoPast["data"]]);
//             } else {
//                 $page->add("weather/badresult", []);
//             }
//         }

//         return $page->render([
//             "title" => $title,
//         ]);
//     }
// }
