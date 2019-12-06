<?php

namespace Anax\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the WeatherModelTest.
 */
class WeatherModelMockTest extends TestCase
{
    // Hold the actual controller.
    protected $controller;

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        // global $di;
        // // Set di as global variable
        // $this->di = new DIFactoryConfig();
        // $di = $this->di;
        // $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        // $di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        // // Use different cache dir for unit test
        // $di->get('cache')->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // $di->setShared("weather", "\Anax\Weather\WeatherModelMock");

        // Setup controllerclass
        // $this->controller = $this->di->get("weather");
        // $this->controller = new WeatherModel;
        // $this->controller->setDI($this->di);


        global $di;
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        
        $this->di = $di;
        // Setup the controller
        $this->controller = new WeatherModel();

        $curl = new \Anax\Curl\CurlModel();

        $this->controller->setCurl($curl);
        $this->controller->setKey("testkeyset");
        $this->controller->setBaseURL("testbaseurl");
        $this->controller->setOptions("testoptions");
    }

    /**
     * Test to setup Model.
     */
    public function testModelSetup()
    {
        $this->assertIsObject($this->controller);
    }

    /**
     * Test the function "getWeatherMulti" with unvalid days.
     */
    public function testMultiUnvalid()
    {
        $lat = "61.0082091";
        $long = "14.5431333";
        $days = 44;
        
        // // Test call with unvalid days
        $res = $this->controller->getWeatherMulti($lat, $long, $days);

        $exp = [
            "match" => false,
            "message" => "Unvalid amount of days."
        ];

        $this->assertEquals($exp, $res);
    }

      /**
     * Test the function "getWeatherMulti" with valid days.
     */
    public function testMultiValid()
    {
        $lat = "61.0082091";
        $long = "14.5431333";
        $days = 15;
        
        // // Test call with unvalid days
        $res = $this->controller->getWeatherMulti($lat, $long, $days);

        $this->assertEquals(true, $res["match"]);
    }

    /**
     * Test the function "getWeather".
     */
    public function testgetWeather()
    {
        $lat = "61.0082091";
        $long = "14.5431333";
        $days = 44;
        
        // // Test call with unvalid days
        $res = $this->controller->getWeather($lat, $long);

        $this->assertIsArray($res);
    }
}
