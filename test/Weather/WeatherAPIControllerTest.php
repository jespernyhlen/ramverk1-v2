<?php

namespace Anax\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the WeatherAPIControllerTest.
 */
class WeatherAPIControllerTest extends TestCase
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

        // Setup controllerclass
        $this->controller = new WeatherAPIController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "index" with no get parameter.
     */
    public function testIndexAction()
    {
        // Test index page return
        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        // Get body and compare results
        $body = $res->getBody();
        $this->assertContains("<h1>Väder API</h1>", $body);
        $this->assertContains("<h1>API Dokumentation</h1>", $body);
        $this->assertContains("<h4>Exempel (utan optionella parametrar)</h4>", $body);
        $this->assertContains("<h4>Exempel (Med optionella parametrar)</h4>", $body);
    }

    /**
     * Test the route "index" with get parameter faulty location.
     */
    public function testIndexActionGetLocationWrong()
    {
        $this->di->get("request")->setGet("location", "sverige,morasdasa");

        // Test action
        $res = $this->controller->indexAction();
        $exp = [[
            "match" => false,
            "location" => [
                "match" => false,
                "message" => "Could not find any matching location"
            ],
            "weatherinfo" => []
        ]];

        $this->assertEquals($exp, $res);
    }

    /**
     * Test the route "index" with get parameter valid location.
     */
    public function testIndexActionGetLocation()
    {
        $this->di->get("request")->setGet("location", "sverige,mora");

        // Test action
        $res = $this->controller->indexAction();
        $exp = [
            "match" => true,
            "latitude" => "61.1428413",
            "longitude" => "14.4176333790821",
            "openstreetmap_link" => "https://www.openstreetmap.org/#map=10/61.1428413/14.4176333790821",
            "location_summary" => "Mora kommun, Dalarnas län, Svealand, Sverige"
        ];
            
        $this->assertEquals($exp, $res[0]["location"]);
        $this->assertInternalType("array", $res[0]["weatherinfo"]["daily"]["data"]);
    }

    /**
     * Test the route "index" with get parameter valid location and prev days.
     */
    public function testIndexActionGetPrevDays()
    {
        $this->di->get("request")->setGet("location", "sverige,mora");
        $this->di->get("request")->setGet("prev", true);
        $this->di->get("request")->setGet("days", 3);

        // Test action
        $res = $this->controller->indexAction();
            
        $this->assertInternalType("array", $res[0]["weatherinfo"]["data"]);
        $this->assertCount(
            3,
            $res[0]["weatherinfo"]["data"],
            "testArray doesn't contains 3 elements"
        );
    }
}
