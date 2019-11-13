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
            "isValid" => true,
            "protocol" => "IPv4",
            "domain" => "metro-cust-37-44-205-237.daladatorer.net"
        ]];
        $this->assertEquals($exp, $res);

        // Test unvalid ip
        $this->di->get("request")->setGet("ip", "327.44.205.237");
        $res = $this->controller->indexAction();
        $exp = [[
            "ipAddress" => "327.44.205.237",
            "isValid" => false,
            "protocol" => null,
            "domain" => null
        ]];
        $this->assertEquals($exp, $res);
    }
}
