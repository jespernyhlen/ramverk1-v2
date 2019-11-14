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
class IpcheckController implements ContainerInjectableInterface
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
     * @return string
     */
    public function indexAction()
    {
        $title = "Validate IP";
        $page = $this->di->get("page");
        $IpValidator = $this->IpValidator;
        $IpGeoInfoModel = $this->IpGeoInfoModel;

        if ($this->di->get("request")->hasGet("ipaddress")) {
            $session = $this->di->get("session");
            $session->set("ipaddress", $this->di->get("request")->getGet("ipaddress"));

            $ipInfo = $this->getIpInfo();
            $page->add("ipcheck/result", $ipInfo);
        }
        $page->add("ipcheck/form-text-geo", [
            "userIp" => $IpValidator->getuserIp(),
        ]);
        $page->add("ipcheck/form-json-geo", [
            "userIp" => $IpValidator->getuserIp(),
        ]);

        return $page->render([
            "title" => $title,
        ]);
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
        $ipAddress = $session->get("ipaddress");

        $ipGeoInfo = $IpGeoInfoModel->getInfo($ipAddress);
        $ipGeoInfo["isValid"] = $IpValidator->isValidIp($ipAddress);
        $ipGeoInfo["domain"] = $IpValidator->getDomain($ipAddress);

        return $ipGeoInfo;
    }

    // public function indexActionGet()
    // {
    //     $title = "Validate IP";
    //     $page = $this->di->get("page");
    //     $ipAddress = $this->di->get("request")->getGet("ipaddress");

    //     $IpValidator = new IpValidate();
    
    //     $page->add("ipcheck/result", [
    //         "ipAddress" => $ipAddress,
    //         "isValid" => $IpValidator->isValidIp($ipAddress),
    //         "protocol" => $IpValidator->getProtocol($ipAddress) ?? null,
    //         "domain" => $IpValidator->getDomain($ipAddress) ?? null,
    //     ]);

    //     return $page->render([
    //         "title" => $title
    //     ]);
    // }
}
