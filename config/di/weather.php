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
                $weather = new \Anax\Weather\WeatherModel();

                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("key_darksky.php");

                // Set Api key
                $weather->setKey($config["config"]["darksky"]["key"]);
                $weather->setBaseUrl($config["config"]["darksky"]["baseUrl"]);
                $weather->setOptions($config["config"]["darksky"]["options"]);

                return $weather;
            }
        ],
    ],
];
