<?php

namespace Jen\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherAPIController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var string $active a sample member variable that gets initialised
     */
    private $isActive = "not active";

    /**
     * Sample initialize
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->isActive = "active";
    }

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
        return __METHOD__ . ", \$isActive is {$this->isActive}";
    }
}
