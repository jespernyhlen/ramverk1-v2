<?php
 namespace Jen\Ipcheck;



 /**
  *
  * @SuppressWarnings(PHPMD.TooManyPublicMethods)
  */
 class IpGeoInfoModel
 {
    /**
     * @var string Api key for ipstack
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
        $this->apiKey = $key["ipstack"] ?? "";
        $this->baseURL = "http://api.ipstack.com/";
    }

    /**
    * Return domain of ip-address
    *
    * @return array
    */
    public function getInfo($IpAddress)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->baseURL . $IpAddress . "?access_key=" . $this->apiKey);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $res = curl_exec($ch);
      $json = json_decode($res, true);
     
      $relevantInfo = [
        "ipAddress" => $json['ip'],
        "protocol" => $json['type'] ?? null,
        "country" => $json['country_name'] ?? null,
        "region" => $json['region_name'] ?? null,
        "city" => $json['city'] ?? null,
        "latitude" => $json['latitude'] ?? null,
        "longitude" => $json['longitude'] ?? null,
        "openstreetmap_link" => null,
    ];

    if ($relevantInfo['latitude'] && $relevantInfo['longitude']) {
      $relevantInfo["openstreetmap_link"] = "https://www.openstreetmap.org/#map=10/{$relevantInfo['latitude']}/{$relevantInfo['longitude']}";
    }
      
      return $relevantInfo;
    }
      
 }