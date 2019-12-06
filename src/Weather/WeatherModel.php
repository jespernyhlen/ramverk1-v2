<?php
namespace Anax\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A model class retrievieng data from an external server.
 */
class WeatherModel implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    
    /**
     * @var object For curl requests
     * @var string Api key
     * @var string Api base url
     * @var string Api options
     *
     */
    protected $curl;
    protected $apiKey;
    protected $baseURL;
    protected $options;
    /**
     * Set Curl object for requests
     *
     * @return void
     */
    public function setCurl(object $curl)
    {
        $this->curl = $curl;
    }
    /**
     * Set Apikey
     *
     * @return void
     */
    public function setKey(string $key)
    {
        $this->apiKey = $key;
    }
    /**
     * Set baseUrl
     *
     * @return void
     */
    public function setBaseURL(string $baseURL)
    {
        $this->baseURL = $baseURL;
    }
    /**
     * Set options
     *
     * @return void
     */
    public function setOptions(string $options)
    {
        $this->options = $options;
    }
    /**
     * Get latitude, longitude from location
     *
     * @return array
     */
    public function convertLocation(string $location) : array
    {
        $url = "https://nominatim.openstreetmap.org/?addressdetails=1&q={$location}&format=json&email=asdf@hotmail.se&limit=1";
        $locationInfo = $this->curl->getCurl($url);
        if (!empty($locationInfo)) {
            $res = [];
            $res["match"] = true;
            $res["latitude"] = $locationInfo[0]["lat"];
            $res["longitude"] = $locationInfo[0]["lon"];
            $res["openstreetmap_link"] = "https://www.openstreetmap.org/#map=10/" . $res['latitude'] . "/" . $res['longitude'];
            $res["location_summary"] = $locationInfo[0]["display_name"] ?? null;
            return $res;
        }
        return [
                "match" => false,
                "message" => "Could not find any matching location"
        ];
    }
    /**
     * Get weather
     *
     * @return array
     */
    public function getWeather(int $lat, $long) : array
    {
        $url = $this->baseURL . $this->apiKey . "/" . $lat . "," . $long . $this->options;
        $weatherInfo = $this->curl->getCurl($url);
        $weatherInfo["match"] = (!empty($weatherInfo)) ? true : false;
        return $weatherInfo;
    }
    /**
     * Get weather mulitcurl
     *
     * @return array
     */
    public function getWeatherMulti(int $lat, $long, $days) : array
    {
        $url = $this->baseURL . $this->apiKey . "/" . $lat . "," . $long;
        $allRequests = [];
        if ($days <= 0 || $days > 30) {
            return [
                "match" => false,
                "message" => "Unvalid amount of days."
            ];
        }
        for ($i=1; $i < $days + 1; $i++) {
            $time = time() - ($i * 60 * 60 * 24);
            $allRequests[] = $url . "," . $time . $this->options;
        }
        $formatedResponse = $this->formatResponse($this->curl->getMultiCurl($allRequests));
        return $formatedResponse;
    }
    /**
     * Format weather response
     *
     * @return array
     */
    public function formatResponse(array $weatherResponse) : array
    {

        $newFormat = [];
        if (!empty($weatherResponse)) {
            $newFormat["match"] = true;
            foreach ($weatherResponse as $key => $row) {
                $newFormat["data"][] = $row["daily"]["data"][0];
            }
        }
        return $newFormat;
    }
}
