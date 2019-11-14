<?php

namespace Jen\Ipcheck;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpcheckControllerTest.
 */
class IpcheckControllerTest extends TestCase
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
        $di->get('cache')->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // Setup controllerclass
        $this->controller = new IpcheckController();
        $this->controller->setDI($this->di);

        // Initialize controller class
        $this->controller->initialize();
    }

    /**
     * Test the route "index" with no get parameter.
     */
    public function testIndexActionNoGet()
    {
        // Test action
        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        // Get body and compare results
        $body = $res->getBody();
        $this->assertContains("<title>Validate IP | ramverk1</title>", $body);
        $this->assertContains("<h1>IP Koll</h1>", $body);
        $this->assertContains("<h4>Text</h4>", $body);
        $this->assertContains("<h4>JSON</h4>", $body);
        $this->assertContains("<h4>Exempel</h4>", $body);
        $this->assertContains("<strong>Get</strong> /ip-api?ip=37.44.205.237", $body);
    }

    /**
     * Test the route "index".
     */
    public function testIndexActionGet()
    {
        $this->di->get("request")->setGet("ipaddress", "37.44.205.237");

        // Test action
        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        // Get body and compare results
        $body = $res->getBody();
        $this->assertContains("<title>Validate IP | ramverk1</title>", $body);
        $this->assertContains("<p><code>37.44.205.237</code> är en validerad IP Address</p>", $body);
        $this->assertContains("<h1>IP Koll</h1>", $body);
        $this->assertContains("<h4>Text</h4>", $body);
        $this->assertContains("<h4>JSON</h4>", $body);
        $this->assertContains("<h4>Exempel</h4>", $body);
        $this->assertContains("<strong>Get</strong> /ip-api?ip=37.44.205.237", $body);
    }

    /**
     * Test the function "getIpInfo" session ip set.
     */
    public function testgetIpInfo()
    {
        $session = $this->di->get("session");
        $session->set("ipaddress", "182.253.75.237");
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

    // /**
    //  * Test the route "indexPost".
    //  */
    // public function testIndexActionPost()
    // {
    //     // Test valid ip
    //     $key = "ipaddress";
    //     $value = "37.44.205.237";
    //     $this->di->get("request")->setPost($key, $value);
    //     $res = $this->controller->indexActionPost();
       
    //     $this->assertInstanceOf("Anax\Response\Response", $res);
    //     $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    //     $body = $res->getBody();
    //     $this->assertContains("<p><code>37.44.205.237</code> är en validerad IP Address", $body);

    //     // Test unvalid ip
    //     $key = "ipaddress";
    //     $value = "37.244.2205.37";
    //     $this->di->get("request")->setPost($key, $value);
    //     $res = $this->controller->indexActionPost();
    //     $this->assertIsObject($res);
    //     $body = $res->getBody();
    //     $this->assertContains("<p><code>37.244.2205.37</code> är inte en validerad IP Address</p>", $body);
    // }
}
