<?php
namespace Anax\View;
?>
<h4>JSON</h4>
<form action="./ip-api" method="get">
<p>Validera en IP Address och visa information i JSON-format. </p>
        <label for="ipaddress">IP Address: </label>
        <input type="text" name="ip" placeholder="Ange IP Address" >
        <input type="submit" value="Validera">
</form>
<h4>Exempel</h4>
<p>API exempel: <code>/ip-api?ip=37.44.205.237</code></p>
<p>Formulär som skickar get-requests till <code>/ip-api</code> med exempel IP adresser <code>?ip={ipadress}</code>.</p>
<p>Ett svar returneras i JSON-format med relevant information tillhörande ip-addressen.</p>

<form action="./ip-api" method="get">
        <input type="submit" name="ip" value="37.44.205.237"> (Validerar)<br><br>
        <input type="submit" name="ip" value="37.424.205.237"> (Validerar ej)
</form>