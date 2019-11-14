<?php
namespace Anax\View;

?>
<h1>IP Koll</h1>
<h4>Text</h4>
<form method="get">
<p>Validera en IP Adress, visa protokoll (IPv4 eller IPv6), domän, geografiska position, land och ort. </p>
        <label for="ipaddress">IP Address: </label>
        <input type="text" name="ipaddress" value="<?= $userIp ?>" placeholder="Ange IP Address" >
        <input type="submit" value="Validera">
</form>