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
class IpcheckController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction()
    {
        $title = "Validate IP result";
        $page = $this->di->get("page");

        // Deal with the action and return a response.
        $page->add("ipcheck/form-text", []);
        $page->add("ipcheck/form-json", []);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function indexActionPost()
    {
        $title = "Validate IP";
        $page = $this->di->get("page");

        $ipAddress = $this->di->get("request")->getPost("ipaddress");

        $isValid = filter_var($ipAddress, FILTER_VALIDATE_IP) ? true : false;

        if ($isValid) {
            $protocol = filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? "IPv4" : "IPv6";
            $domain = gethostbyaddr($ipAddress);
        }
    
        $page->add("ipcheck/result", [
            "ipAddress" => $ipAddress,
            "isValid" => $isValid,
            "protocol" => $protocol ?? null,
            "domain" => $domain ?? null
        ]);

        return $page->render([
            "title" => $title
        ]);
    }
}