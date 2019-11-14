<?php
namespace Anax\View;

?>
<h4>JSON</h4>
<form action="./ip-api" method="get">
<p>Validera en IP Adress och visa information i JSON-format. </p>
        <label for="ipaddress">IP Adress: </label>
        <input type="text" name="ip"  value="<?= $userIp ?>" placeholder="Ange IP Address" >
        <input type="submit" value="Validera">
</form>
<h1>API</h1>
<p>APIet tar emot get-requests till <code>/ip-api</code> med ip adress <code>?ip={ipadress}</code>.</p>
<p>Ett svar returneras i JSON-format med relevant information tillhörande ip-adressen.</p>
<code><strong>Get</strong> /ip-api?ip={ip adress}</code>

<h4>Exempel</h4>
<code><strong>Get</strong> /ip-api?ip=37.44.205.237</code>

<pre><code>{
    "ipAddress": "37.44.205.237",
    "protocol": "ipv4",
    "country": "Sweden",
    "region": "Dalarnas Lan",
    "city": "Mora Kommun",
    "latitude": 61.006999969482421875,
    "longitude": 14.5431995391845703125,
    "openstreetmap_link": "https://www.openstreetmap.org/#map=10/61.006999969482/14.543199539185",
    "isValid": true,
    "domain": "metro-cust-37-44-205-237.daladatorer.net"
}</code></pre>

<h4>Testroutes</h4>
<form action="./ip-api" method="get">
        <input class="testroute" type="submit" name="ip" value="37.44.205.237"> (Validerar)<br>
        <input class="testroute" type="submit" name="ip" value="2001:0db8:85a3:0000:0000:8a2e:0370:7334"> (Validerar)<br>
        <input class="testroute" type="submit" name="ip" value="37.424.205.237"> (Validerar ej)<br>
        <input class="testroute" type="submit" name="ip" value="77779:0db8:85a3:0000:0000:8a2e:0370:7334"> (Validerar ej)<br>
</form>

