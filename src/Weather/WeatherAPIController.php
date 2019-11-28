<?php

namespace Anax\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherAPIController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction()
    {
        $title = "Weather info";
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $request = $this->di->get("request");

        if ($request->hasGet("location")) {
            if ($request->hasGet("prev", true) && $request->hasGet("days")) {
                return $this->getWeather($request->getGet("location"), $request->getGet("days"));
            }
            return $this->getWeather($request->getGet("location"));
        }
        $page->add("weather/form-json-weather", []);
        $page->add("weather/api-exemple", []);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Get weather
     * Today, and next 7 days or
     * Previous days
     *
     * @return array
     */
    public function getWeather($location, $days = null)
    {
        $CurlModel = $this->di->get("curl");
        $WeatherModel = $this->di->get("weather");
        $WeatherModel->setCurl($CurlModel);
        
        $weatherInfo = [];
        $convertedLocation = $WeatherModel->convertLocation($location);
        ini_set('serialize_precision', -1);
        
        if ($convertedLocation["match"] && $days !== null) {
            $weatherInfo = $WeatherModel->getWeatherMulti($convertedLocation["latitude"], $convertedLocation["longitude"], $days);
        } else if ($convertedLocation["match"]) {
            $weatherInfo = $WeatherModel->getWeather($convertedLocation["latitude"], $convertedLocation["longitude"], $days);
        }
        return [[
            "match" => $convertedLocation["match"],
            "location" => $convertedLocation,
            "weatherinfo" => $weatherInfo
        ]];
    }
}
