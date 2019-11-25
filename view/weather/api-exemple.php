<?php
namespace Anax\View;

?>
<h1>API Dokumentation</h1>
<p>APIet tar emot get-requests till <code>/weather-api</code> med en plats <code>?location={plats}</code>.<br>
Ett svar returneras i JSON-format med relevant information om platsen, samt vädret idag och 7 dagar framåt.<br>
För en mer specifik sökning separeras söksträngen med <code>,</code> Exempel: <code>/weather-api?location=norge,oslo</code></p>
<code><strong>Get</strong> /weather-api?location={plats}</code>
<h4>Optionella parametrar</h4>
<p>För att få historisk väderdata används parametrarna <code>?prev=true&days={antal dagar}</code> i tillägg till plats. Minimum 1 dag och maximalt 30 dagar tillbaka visar prognosen.</p>

<code><strong>Get</strong> /weather-api?location={plats}&prev=true&days={antal dagar}</code>
<h4>Exempel (utan optionella parametrar)</h4>
<p><code><strong>Get</strong> /weather-api?location=umeå</code><br>
<a href="./weather-api?location=umeå">/weather-api?location=umeå</a></p>

<pre><code>{
    "match": true,
    "location": {
        "match": true,
        "latitude": 63.8420643500000011272277333773672580718994140625,
        "longitude": 20.2536120020699996757684857584536075592041015625,
        "openstreetmap_link": "https://www.openstreetmap.org/#map=10/63.84206435/20.25361200207",
        "location_summary": "Ume\u00e5, Ume\u00e5 kommun, V\u00e4sterbotten, V\u00e4sterbottens l\u00e4n, Norrland, Sverige",
    },
    weatherinfo: {
        "latitude": 63,
        "longitude": 20.2536120020699996757684857584536075592041015625,
        "timezone": "Europe/Stockholm",
        "daily": {
            "summary": "Regnskurar p\u00e5 l\u00f6rdag och n\u00e4sta torsdag.",
            "icon": "rain",
            "data": [
                {
                "time": 1574290800,
                "summary": "Mulet under dagen.",
                "icon": "cloudy",
                "sunriseTime": 1574320560,
                "sunsetTime": 1574343360,
                "moonPhase": 0.82,
                "precipIntensity": 0.0257,
                "precipIntensityMax": 0.0664,
                "precipIntensityMaxTime": 1574350500,
                "precipProbability": 0.29,
                "precipType": "rain",
                "temperatureHigh": 5.28,
                "temperatureHighTime": 1574316060,
                "temperatureLow": 2.96,
                "temperatureLowTime": 1574393760,
                "apparentTemperatureHigh": 1.5,
                "apparentTemperatureHighTime": 1574316000,
                "apparentTemperatureLow": -2.63,
                "apparentTemperatureLowTime": 1574406000,
                "dewPoint": 3.6,
                "humidity": 0.94,
                "pressure": 1030.7,
                "windSpeed": 5.95,
                "windGust": 10.56,
                "windGustTime": 1574377200,
                "windBearing": 166,
                "cloudCover": 0.81,
                "uvIndex": 0,
                "uvIndexTime": 1574331720,
                "visibility": 16.093,
                "ozone": 221.4,
                "temperatureMin": 3.53,
                "temperatureMinTime": 1574377200,
                "temperatureMax": 5.28,
                "temperatureMaxTime": 1574316060,
                "apparentTemperatureMin": -1.64,
                "apparentTemperatureMinTime": 1574377200,
                "apparentTemperatureMax": 1.54,
                "apparentTemperatureMaxTime": 1574314020
                },
                ... ( 7 days more of weather information )
            ]
        },
        offset: 1,
        match: true
        }
   
}</code></pre>

<h4>Exempel (Med optionella parametrar)</h4>

<p><code><strong>Get</strong> /weather-api?location=umeå&prev=true&days=4</code><br>
<a href="./weather-api?location=umeå&prev=true&days=4">/weather-api?location=umeå&prev=true&days=4</a></p>

<pre><code>{
    "match": true,
    "location": {
        "match": true,
        "latitude": 63.8420643500000011272277333773672580718994140625,
        "longitude": 20.2536120020699996757684857584536075592041015625,
        "openstreetmap_link": "https://www.openstreetmap.org/#map=10/63.84206435/20.25361200207",
        "location_summary": "Ume\u00e5, Ume\u00e5 kommun, V\u00e4sterbotten, V\u00e4sterbottens l\u00e4n, Norrland, Sverige",
    },
    weatherinfo: {
        "match": true,
        "data": [
            {
                "time": 1574204400,
                "summary": "M\u00f6jligtvis l\u00e4tta regnskurar p\u00e5 morgonen.",
                "icon": "rain",
                "sunriseTime": 1574234040,
                "sunsetTime": 1574257080,
                "moonPhase": 0.78,
                "precipIntensity": 0.2342,
                "precipIntensityMax": 1.358,
                "precipIntensityMaxTime": 1574211900,
                "precipProbability": 0.87,
                "precipType": "rain",
                "temperatureHigh": 4.97,
                "temperatureHighTime": 1574229600,
                "temperatureLow": 3.78,
                "temperatureLowTime": 1574297760,
                "apparentTemperatureHigh": 1.12,
                "apparentTemperatureHighTime": 1574272800,
                "apparentTemperatureLow": 0.59,
                "apparentTemperatureLowTime": 1574297640,
                "dewPoint": 3.94,
                "humidity": 0.95,
                "pressure": 1023.8,
                "windSpeed": 6.59,
                "windGust": 17.95,
                "windGustTime": 1574206680,
                "windBearing": 203,
                "cloudCover": 0.93,
                "uvIndex": 0,
                "uvIndexTime": 1574245500,
                "visibility": 14.797,
                "ozone": 242.2,
                "temperatureMin": 3.92,
                "temperatureMinTime": 1574287200,
                "temperatureMax": 5.75,
                "temperatureMaxTime": 1574207640,
                "apparentTemperatureMin": -0.82,
                "apparentTemperatureMinTime": 1574211420,
                "apparentTemperatureMax": 1.32,
                "apparentTemperatureMaxTime": 1574282220
            },
            ... ( 3 days more of previous weather information )
        ]
    }
   
}</code></pre>


