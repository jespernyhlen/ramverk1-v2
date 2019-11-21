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
     *
     */
    protected $apiKey;
    protected $baseURL;

    /**
     * Get and set APikey from local keyfile
     *
     * @return void
     */
    public function __construct()
    {
        $key = require ANAX_INSTALL_PATH . "/config/apikey.php";
        $this->apiKey = $key["darksky"] ?? "";
        $this->baseURL = "https://api.darksky.net/forecast/";
        $this->baseOptions = "?exclude=currently,hourly,minutely,flags&extend=daily&units=si&lang=sv";

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
            $res["latitude"] = floatval($locationInfo[0]["lat"]);
            $res["longitude"] = floatval($locationInfo[0]["lon"]);
            $res["display_name"] = $locationInfo[0]["display_name"] ?? null;
            $res["place"] = $locationInfo[0]["address"]["hamlet"] ?? null;
            $res["town"] = $locationInfo[0]["address"]["town"] ?? null;
            $res["county"] = $locationInfo[0]["address"]["county"] ?? null;
            $res["state"] = $locationInfo[0]["address"]["state"] ?? null;
            $res["postcode"] = $locationInfo[0]["address"]["postcode"] ?? null;
            $res["country"] = $locationInfo[0]["address"]["country"] ?? null;

            return $res;
        }
        return [];
    }


    /**
     * Get weather
     *
     * @return array
     */
    public function getWeather(int $lat, $long) : array
    {
        $url = $this->baseURL . $this->apiKey . "/" . $lat . "," . $long . $this->baseOptions;

        return $this->getCurl($url);;
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
    public function getWeatherMulti(int $lat, $long) : array
    {
        $url = $this->baseURL . $this->apiKey . "/" . $lat . "," . $long;
        $allRequests = [];
        for ($i=0; $i < 2; $i++) {
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
        foreach ($weatherResponse as $key => $row) {
            $newFormat[] = $row["daily"]["data"][0];
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