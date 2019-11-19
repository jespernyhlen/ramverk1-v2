<?php
/**
 * Route for ipcheck controller
 */
return [
    "routes" => [
        [
            "info" => "Weather.",
            "mount" => "weather/web",
            "handler" => "\Jen\Weather\WeatherController",
        ],
    ]
];
