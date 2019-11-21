<?php

namespace Jen\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

     /**
     * @var object $WeatherModel class for weatherinfo
     *
     */
    private $WeatherModel;

    /**
     * Sample initialize
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->WeatherModel = new WeatherModel();
    }

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
        $WeatherModel = $this->WeatherModel;

        $request = $this->di->get("request");

        $page->add("weather/form-text-weather", []);
        $page->add("weather/clear", []);

        if ($this->di->get("request")->hasGet("location")) {
            $convertedLocation = $WeatherModel->convertLocation($request->getGet("location"));
            if (!empty($convertedLocation)) {

                $weatherInfo["location"] = $convertedLocation;
                $weatherInfo["weather"] = $this->getWeatherInfo($convertedLocation["latitude"], $convertedLocation["longitude"]);

                $weatherInfoPast["pastweather"] = $this->getWeatherInfoPast($convertedLocation["latitude"], $convertedLocation["longitude"]);
                $page->add("weather/location", ["location" => $weatherInfo["location"]]);
                $page->add("weather/result", ["weatherinfo" => $weatherInfo]);
                $page->add("weather/resultpast", ["weatherinfo" => $weatherInfoPast]);
            } else {
                $page->add("weather/badresult", []);
            }
        }

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Get weather next 7 days
     *
     * @return array
     */
    public function getWeatherInfo($lat, $long)
    {
        $WeatherModel = $this->WeatherModel;
        $weatherInfo = $WeatherModel->getWeather($lat, $long);
            // var_dump($weatherInfo["daily"]["data"]);

        return $weatherInfo;

    }

    /**
     * Get weather past 30 days
     *
     * @return array
     */
    public function getWeatherInfoPast($lat, $long)
    {
        $WeatherModel = $this->WeatherModel;
        $weatherInfo = $WeatherModel->getWeatherMulti($lat, $long);
        
        return $weatherInfo;

    }
}
