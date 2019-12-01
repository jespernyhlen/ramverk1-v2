<?php
/**
 *    Change name to apikey.php and add api keys for external APIs.
 */
return [
    "darksky" => [
        "key" =>"YOUR_KEY",
        "baseUrl" => "https://api.darksky.net/forecast/",
        "options" => "?exclude=currently,hourly,minutely,flags,alerts&extend=daily&units=si&lang=sv",
    ]
];
