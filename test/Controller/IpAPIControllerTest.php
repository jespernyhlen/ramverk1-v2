<?php

namespace Jen\Ipcheck;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpAPIControllerTest.
 */
class IpAPIControllerTest extends TestCase
{

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;
        // Set di as global variable
        $this->di = new DIFactoryConfig();
        $di = $this->di;
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // Setup controllerclass
        $this->controller = new IpAPIController();
        $this->controller->setDI($this->di);

        // Initialize controller class
        $this->controller->initialize();

    }

    
    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        // Test valid ip
        $this->di->get("request")->setGet("ip", "37.44.205.237");
        $res = $this->controller->indexAction();
        $exp = [[
            "ipAddress" => "37.44.205.237",
            "protocol" => "ipv4",
            "country" => "Sweden",
            "region" => "Dalarnas Lan",
            "city" => "Mora Kommun",
            "latitude" => 61.006999969482421875,
            "longitude" => 14.5431995391845703125,
            "openstreetmap_link" => "https://www.openstreetmap.org/#map=10/61.006999969482/14.543199539185",
            "isValid" => true,
            "domain" => "metro-cust-37-44-205-237.daladatorer.net"
        ]];
        $this->assertEquals($exp, $res);

        // Test unvalid ip
        $this->di->get("request")->setGet("ip", "327.44.205.237");
        $res = $this->controller->indexAction();
        $exp = [[
            "ipAddress" => "327.44.205.237",
            "protocol" => null,
            "country" => null,
            "region" => null,
            "city" => null,
            "latitude" => null,
            "longitude" => null,
            "openstreetmap_link" => null,
            "isValid" => false,
            "domain" => null
        ]];
        $this->assertEquals($exp, $res);
    }


    /**
     * Test the route "index" wrong get parameter.
     */
    public function testIndexWrongAction()
    {
        // Test valid ip
        $this->di->get("request")->setGet("ips", "37.44.205.237");
        $res = $this->controller->indexAction();
        $exp = [[
            "message" => "Not a valid API route"
        ]];
        $this->assertEquals($exp, $res);
    }

    /**
     * Test the function "getIpInfo" session ip set.
     */
    public function testgetIpInfo()
    {
        $session = $this->di->get("session");
        $session->set("ip", "182.253.75.237");
        // Test valid ip
        $res = $this->controller->getIpInfo();
        $exp = [
            "ipAddress" => "182.253.75.237",
            "protocol" => "ipv4",
            "country" => "Indonesia",
            "region" => "Jakarta",
            "city" => "Jakarta",
            "latitude" => -6.173799991607666015625,
            "longitude" => 106.82669830322265625,
            "openstreetmap_link" => "https://www.openstreetmap.org/#map=10/-6.1737999916077/106.82669830322",
            "isValid" => true,
            "domain" => "182.253.75.237"
        ];
        $this->assertEquals($exp, $res);
        $session->destroy();
    }

     /**
     * Test the function "getIpInfo" session ip not set.
     */
    public function testgetIpInfoNoSession()
    {
        // Test function with no session started
        $res = $this->controller->getIpInfo();
        $exp = [];
        $this->assertEquals($exp, $res);
    }
}
