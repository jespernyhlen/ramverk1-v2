<?php
/**
 * Route for ipcheck controller
 */
return [
    "routes" => [
        [
            "info" => "Weather.",
            "mount" => "weather",
            "handler" => "\Jen\Weather\WeatherController",
        ],
    ]
];
