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

        // Use different cache dir for unit test
        $di->get('cache')->setPath(ANAX_INSTALL_PATH . "/test/cache");
        
        $di->setShared("weather", "\Anax\Weather\WeatherModelMock");

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
        $this->di->get("request")->setGet("location", "malung");

        // Test action
        $res = $this->controller->indexAction();
        $exp = [
            "match" => true,
            "latitude" => "60.6864461",
            "longitude" => "13.7145867",
            "openstreetmap_link" => "https://www.openstreetmap.org/#map=10/60.6864461/13.7145867",
            "location_summary" => 'Malung, Malung-Sälens kommun, Dalarnas län, Svealand, 78231, Sverige'
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
        $this->di->get("request")->setGet("days", 4);

        // Test action
        $res = $this->controller->indexAction();
        // print_r($res);
            
        $this->assertInternalType("array", $res[0]["weatherinfo"]["data"]);
        $this->assertCount(
            4,
            $res[0]["weatherinfo"]["data"]
        );
    }
}
