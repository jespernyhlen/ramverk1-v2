<?php
namespace Anax\View;

?>
<h1>Väder API</h1>
<form method="get">
<p>Sök på plats och få väderinformation. Exempel: "sverige,borlänge", "göteborg", "dalarna,malung" </p>
        <label for="location">Plats </label>
        <input type="text" name="location" placeholder="Plats för väderinformation" >
        <input type="submit" value="Visa">
</form>