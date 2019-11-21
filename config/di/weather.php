<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "weather" => [
            "shared" => true,
            "callback" => function () {
                $Weather = new \Jen\Weather\WeatherModel();

                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("apiKey.php");

                // Set Api key
                $Weather->setKey($config["config"]["darksky"]);

                return $Weather;
            }
        ],
    ],
];
