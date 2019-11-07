<?php

namespace Jen\Ipcheck;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IpAPIController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

/**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return array
     */
    public function indexAction() : array
    {
        $ipAddress = $this->di->request->getGet("ip");
        $isValid = filter_var($ipAddress, FILTER_VALIDATE_IP) ? true : false;

        if ($isValid) {
            $protocol = filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? "IPv4" : "IPv6";
            $domain = gethostbyaddr($ipAddress);
        }

        $json = [
            "ipAddress" => $ipAddress,
            "isValid" => $isValid,
            "protocol" => $protocol ?? null,
            "domain" => $domain ?? null,
        ];

        // Deal with the action and return a response.
        return [$json];
    }
}
