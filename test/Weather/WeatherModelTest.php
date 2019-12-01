<?php

namespace Anax\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the WeatherModelTest.
 */
class WeatherModelTest extends TestCase
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

        // Setup controllerclass
        $this->controller = new WeatherModel();
    }

    /**
     * Test the function "getWeatherMulti" with unvalid days.
     */
    public function testIndexActionNoGet()
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
}
