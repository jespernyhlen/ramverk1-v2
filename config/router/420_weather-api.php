<?php
/**
 * Route for ipcheck controller
 */
return [
    "routes" => [
        [
            "info" => "Weather api.",
            "mount" => "weather/weather-api",
            "handler" => "\Jen\Weather\WeatherAPIController",
        ],
    ]
];
