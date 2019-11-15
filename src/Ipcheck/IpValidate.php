<?php
namespace Jen\Ipcheck;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A sample controller to show how a controller class can be implemented.
* The controller will be injected with $di if implementing the interface
* ContainerInjectableInterface, like this sample class does.
* The controller is mounted on a particular route and can then handle all
* requests for that mount point.
*
* @SuppressWarnings(PHPMD.TooManyPublicMethods)
*/
class IpValidate implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    /**
     * Check if ip-address is valid
    *
    * @return bool
    */
    public function isValidIp($IpAddress)
    {
        if (filter_var($IpAddress, FILTER_VALIDATE_IP)) {
            return true;
        }
        return false;
    }


    /**
     * Return if IPv4 or IPv6 protocol
    *
    * @return string
    */
    public function getProtocol($IpAddress)
    {
        if (filter_var($IpAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return "IPv4";
        }
        if (filter_var($IpAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return "IPv6";
        }
        return "Undefined";
    }
    

    /**
     * Return domain of ip-address
    *
    * @return string
    */
    public function getDomain($IpAddress)
    {
        if (filter_var($IpAddress, FILTER_VALIDATE_IP)) {
            return gethostbyaddr($IpAddress);
        }
    }

    /**
     * Return default ip-address of user
    *
    * @return string
    */
    public function getUserIp($request)
    {
        if (!empty($request->getServer('HTTP_CLIENT_IP'))) {
            //whether ip is from share internet
            $ip_address = $request->getServer('HTTP_CLIENT_IP');
        } elseif (!empty($request->getServer('HTTP_X_FORWARDED_FOR'))) {
            //whether ip is from proxy
            $ip_address = $request->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            //whether ip is from remote address
            $ip_address = $request->getServer('REMOTE_ADDR');
        }
        return $ip_address;
    }
}
