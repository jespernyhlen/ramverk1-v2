<?php
namespace Jen\Weather;


/**
 * A model class retrievieng data from an external server.
 */
class WeatherModel
{
    /**
     * @var string Api key
     * @var string Api base url
     * @var string Api base options
     * 
     *
     */
    protected $apiKey;
    protected $baseURL;
    protected $baseOptions;


    /**
     * Set Api options
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseURL = "https://api.darksky.net/forecast/";
        $this->baseOptions = "?exclude=currently,hourly,minutely,flags,alerts&extend=daily&units=si&lang=sv";
    }

    /**
     * Set Apikey
     *
     * @return void
     */
    public function setKey($key)
    {
        $this->apiKey = $key;
    }

    /**
     * Get latitude, longitude from location
     *
     * @return array
     */
    public function convertLocation(string $location) : array
    {
        $url = "https://nominatim.openstreetmap.org/?addressdetails=1&q={$location}&format=json&email=asdf@hotmail.se&limit=1";
        $locationInfo = $this->getCurl($url);

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
        $url = $this->baseURL . $this->apiKey . "/" . $lat . "," . $long . $this->baseOptions;
        $weatherInfo = $this->getCurl($url);
        $weatherInfo["match"] = (!empty($weatherInfo)) ? true : false;

        return $weatherInfo;
    }

    /**
     * Get curl from given url
     *
     * @return array
     */
    public function getCurl(string $url) : array
    {
        //  Initiate curl handler
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Execute
        $data = curl_exec($ch);
        // Closing
        curl_close($ch);

        return json_decode($data, true) ?? [];
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
            $allRequests[] = $url . "," . $time . $this->baseOptions;
        }
        $formatedResponse = $this->formatResponse($this->getWeatherssThroughMultiCurl($allRequests));
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

    /**
     * Get weather mulitcurl
     *
     * @return array
     */
    public function getWeatherssThroughMultiCurl(array $urls) : array
    {
        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];
        // Add all curl handlers and remember them
        // Initiate the multi curl handler
        $mh = curl_multi_init();
        $chAll = [];
        foreach ($urls as $url) {
            $ch = curl_init("$url");
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $chAll[] = $ch;
        }
        // Execute all queries simultaneously,
        // and continue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        // Close the handles
        foreach ($chAll as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);
        // All of our requests are done, we can now access the results
        $response = [];
        foreach ($chAll as $ch) {
            $data = curl_multi_getcontent($ch);
            $response[] = json_decode($data, true);
        }
        return $response;
    }

}