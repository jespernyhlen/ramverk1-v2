<?php

namespace Jen\Ipcheck;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IpAPIController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var object $IpValidator class for validating ip address
     * @var object $IpGeoInfoModel class for location info for ip addresses
     * 
     */
    private $IpValidator;
    private $IpGeoInfoModel;

    /**
     * set model classes for validation an info 
     *
     * @return void
     */
    public function initialize()
    {
        $this->IpValidator = new IpValidate();
        $this->IpGeoInfoModel = new IpGeoInfoModel();
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return array
     */
    public function indexAction() : array
    {
        $ipAddress = $this->di->request->getGet("ip");
        if ($this->di->get("request")->hasGet("ip")) {
            $session = $this->di->get("session");
            $session->set("ip", $this->di->get("request")->getGet("ip"));
            $ipInfo = $this->getIpInfo();
            
            return [$ipInfo];
        }


       

        // Deal with the action and return a response.
    }

    /**
     * Get info for views about ip addresses
     *
     * @return array
     */
    public function getIpInfo()
    {
        $IpValidator = $this->IpValidator;
        $IpGeoInfoModel = $this->IpGeoInfoModel;

        $session = $this->di->get("session");
        $ipAddress = $session->get("ip");
        $geoInfo = $IpGeoInfoModel->getInfo($ipAddress);

        $json = [
            "ipAddress" => $ipAddress,
            "isValid" => $IpValidator->isValidIp($ipAddress),
            "protocol" => $IpValidator->getProtocol($ipAddress) ?? null,
            "domain" => $IpValidator->getDomain($ipAddress) ?? null,
            "country" => $geoInfo['country_name'] ?? null,
            "city" => $geoInfo['city'] ?? null,
            "latitude" => $geoInfo['latitude'] ?? null,
            "longitude" => $geoInfo['longitude'] ?? null,
            "openstreetmap_link" => $geoInfo['openstreetmap_link'] ?? null,
        ];
    
        return $json;
    }
}




// <?php

// namespace Jen\Ipcheck;

// use Anax\Commons\ContainerInjectableInterface;
// use Anax\Commons\ContainerInjectableTrait;

// // use Anax\Route\Exception\ForbiddenException;
// // use Anax\Route\Exception\NotFoundException;
// // use Anax\Route\Exception\InternalErrorException;

// /**
//  * A sample controller to show how a controller class can be implemented.
//  * The controller will be injected with $di if implementing the interface
//  * ContainerInjectableInterface, like this sample class does.
//  * The controller is mounted on a particular route and can then handle all
//  * requests for that mount point.
//  *
//  * @SuppressWarnings(PHPMD.TooManyPublicMethods)
//  */
// class IpAPIController implements ContainerInjectableInterface
// {
//     use ContainerInjectableTrait;

//     /**
//      * This is the index method action, it handles:
//      * ANY METHOD mountpoint
//      * ANY METHOD mountpoint/
//      * ANY METHOD mountpoint/index
//      *
//      * @return array
//      */
//     public function indexAction() : array
//     {
//         $ipAddress = $this->di->request->getGet("ip");

//         $IpValidator = new IpValidate();

//         $json = [
//             "ipAddress" => $ipAddress,
//             "isValid" => $IpValidator->isValidIp($ipAddress),
//             "protocol" => $IpValidator->getProtocol($ipAddress) ?? null,
//             "domain" => $IpValidator->getDomain($ipAddress) ?? null,
//         ];

//         // Deal with the action and return a response.
//         return [$json];
//     }

//      /**
//      *
//      * @return array
//      */
//     public function geoAction()
//     {
//         $ipAddress = $this->di->request->getGet("ip");

//         $IpValidator = new IpValidate();
    
//         $json = [
//             "info" => $IpValidator->getInfo($ipAddress) ?? null
//         ];
//         return [$json];
//     }
// }
