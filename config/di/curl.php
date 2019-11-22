<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "curl" => [
            "shared" => true,
            "callback" => function () {
                $curl = new \Jen\Curl\CurlModel();

                return $curl;
            }
        ],
    ],
];
