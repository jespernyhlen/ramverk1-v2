<?php

namespace Anax\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the WeatherControllerTest.
 */
class WeatherControllerTest extends TestCase
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
        $di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        // Use different cache dir for unit test
        $di->get('cache')->setPath(ANAX_INSTALL_PATH . "/test/cache");

        $di->setShared("weather", "\Anax\Weather\WeatherModelMock");

        // Setup controllerclass
        $this->controller = new WeatherController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "index" with no get parameter.
     */
    public function testIndexActionNoGet()
    {
        // // Test action
        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        // Get body and compare results
        $body = $res->getBody();
        $this->assertContains("<h1>Väder</h1>", $body);
        $this->assertContains("Sök på plats och få väderinformation", $body);
        $this->assertContains("<input", $body);
    }

    /**
     * Test the route "index" with get parameter.
     */
    public function testIndexActionGet()
    {
        $this->di->get("request")->setGet("location", "sverige,mora");

        // Test action
        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        // Get body and compare results
        $body = $res->getBody();
        $this->assertContains("<h1>Plats</h1>", $body);
        $this->assertContains("<div style=\"height: 400px;\" id=\"map\"></div>", $body);
        $this->assertContains("<h1>Väder idag och kommande 7 dagar</h1>", $body);
        $this->assertContains("<h1>Senaste 30 dagar</h1>", $body);
    }

    /**
     * Test the route "index" with get parameter and no match.
     */
    public function testIndexActionGetNoMatch()
    {
        $this->di->get("request")->setGet("location", "sverige,morasdaa");

        // Test action
        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        // Get body and compare results
        $body = $res->getBody();
        $this->assertContains("Kunde inte hitta någon information, pröva en annan plats.", $body);
    }
}
