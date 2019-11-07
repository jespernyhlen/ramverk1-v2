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
        $di->set("request", "\Anax\Request\Request");
    }

    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {

        // Test action
        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        // Get body and compare results
        $body = $res->getBody();
        $this->assertContains("<title>Validate IP result | ramverk1</title>", $body);
        $this->assertContains("<h1>IP Koll</h1>", $body);
        $this->assertContains("<h4>Text</h4>", $body);
        $this->assertContains("<h4>JSON</h4>", $body);
        $this->assertContains("<h4>Exempel</h4>", $body);
    }

    /**
     * Test the route "indexPost".
     */
    public function testIndexActionPost()
    {
        $_POST["ipaddress"] = "37.244.205.237";
        // Test valid ip
        $res = $this->controller->indexActionPost();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
        $body = $res->getBody();
        $this->assertContains("<p><code>37.244.205.237</code> är en validerad IP Address</p>", $body);

        $_POST["ipaddress"] = "37.244.2205.37";
        // Test unvalid ip
        $res = $this->controller->indexActionPost();
        $this->assertIsObject($res);
        $body = $res->getBody();
        $this->assertContains("<p><code>37.244.2205.37</code> är inte en validerad IP Address</p>", $body);
    }
}
