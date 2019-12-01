<?php
/**
 * Route for ip-api
 */
return [
    "routes" => [
        [
            "info" => "Ipcheck.",
            "mount" => "ip-api",
            "handler" => "\Jen\Ipcheck\IpAPIController",
        ],
    ]
];
