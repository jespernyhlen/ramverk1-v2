<?php
/**
 * Route for ipcheck controller
 */
return [
    "routes" => [
        [
            "info" => "Weather api.",
            "mount" => "weather-api",
            "handler" => "\Jen\Weather\WeatherAPIController",
        ],
    ]
];
