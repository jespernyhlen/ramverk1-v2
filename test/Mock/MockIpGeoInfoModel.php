<?php
namespace Jen\Ipcheck;

/**
 *
* Mockclass for IpGeoInfoModel
*/
class MockIpGeoInfoModel extends IpGeoInfoModel
{

    /**
    * Return domain of ip-address
    *
    * @return array
    */
    public function getInfo($IpAddress)
    {
        $relevantInfo = [
            "ipAddress" => $IpAddress,
            "protocol" => "ipv4",
            "country" => "Indonesia",
            "region" => "Jakarta",
            "city" => "Jakarta",
            "latitude" => -6.173799991607666015625,
            "longitude" => 106.82669830322265625,
            "openstreetmap_link" => null,
        ];

        if ($relevantInfo['latitude'] && $relevantInfo['longitude']) {
            $relevantInfo["openstreetmap_link"] = "https://www.openstreetmap.org/#map=10/{$relevantInfo['latitude']}/{$relevantInfo['longitude']}";
        }
        return $relevantInfo;
    }
}
