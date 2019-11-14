<?php

namespace Jen\Ipcheck;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpGeoInfoModel.
 */
class IpGeoInfoModelTest extends TestCase
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
        $this->ipGeoInfo = new MockIpGeoInfoModel();
    }

    /**
     * Test the "getInfo" method true results.
     */
    public function testgetInfo()
    {
        // Test valid ip
        $res = $this->ipGeoInfo->getInfo("37.44.205.237");

        $this->assertNotEquals($res["openstreetmap_link"], null);
    }

 
}
