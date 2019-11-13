<?php

namespace Jen\Ipcheck;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpValidate.
 */
class IpValidatorTest extends TestCase
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
        $this->validator = new IpValidate();
        $this->validator->setDI($this->di);
    }

    /**
     * Test the "isValidIp" method true results.
     */
    public function testisValidIpTrue()
    {
        // Test valid ip
        $res1 = $this->validator->isValidIp("37.44.205.237");
        $res2 = $this->validator->isValidIp("182.253.75.237");
        $res3 = $this->validator->isValidIp("2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $res4 = $this->validator->isValidIp("2001:DB8:7654:3210:FEDC:BA98:7654:3210");

        $this->assertEquals([$res1, $res2, $res3, $res4], [true, true, true, true]);
    }

     /**
     * Test the "isValidIp" method false results.
     */
    public function testisValidIpFalse()
    {
        // Test unvalid ip
        $res1 = $this->validator->isValidIp("372.44.205.237");
        $res2 = $this->validator->isValidIp("182.253.735.237");
        $res3 = $this->validator->isValidIp("2001:0db8:8ace3:0000:0000:8a2e:0370:7334");
        $res4 = $this->validator->isValidIp("20011:DB8:7654:3210:FEDC:BA98:7654:3210");

        $this->assertEquals([$res1, $res2, $res3, $res4], [false, false, false, false]);

    }

    /**
     * Test the "getProtocol" method.
     */
    public function testgetProtocolIPv4()
    {
        $res1 = $this->validator->getProtocol("37.44.205.237");
        $res2 = $this->validator->getProtocol("182.253.75.237");

        $this->assertEquals([$res1, $res2], ["IPv4", "IPv4"]);
    }

     /**
     * Test the "getProtocol" method.
     */
    public function testgetProtocolIPv6()
    {
        $res1 = $this->validator->getProtocol("2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $res2 = $this->validator->getProtocol("2001:DB8:7654:3210:FEDC:BA98:7654:3210");

        $this->assertEquals([$res1, $res2], ["IPv6", "IPv6"]);
    }

    /**
    * Test the "getDomain" method.
    */
   public function testgetDomain()
   {
       // Test valid ip
       $res1 = $this->validator->getDomain("37.44.205.237");
       $res2 = $this->validator->getDomain("127.0.0.1");
       $res3 = $this->validator->getDomain("8.8.8.8");
       $res4 = $this->validator->getDomain("194.47.129.123");

       $this->assertEquals([$res1, $res2, $res3, $res4], ["metro-cust-37-44-205-237.daladatorer.net", "localhost", "dns.google", "abuse.bth.se"]);
   }

    /**
    * Test the "getDomain" method.
    */
    public function testgetDomainNull()
    {
        // Test valid ip
        $res1 = $this->validator->getDomain("372.44.205.237");
        $res2 = $this->validator->getDomain("182.253.735.237");
        $res3 = $this->validator->getDomain("2001:0db8:8ace3:0000:0000:8a2e:0370:7334");
        $res4 = $this->validator->getDomain("20011:DB8:7654:3210:FEDC:BA98:7654:3210");
 
        $this->assertEquals([$res1, $res2, $res3, $res4], [null, null, null, null]);
    }
}
