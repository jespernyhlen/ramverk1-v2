<?php
namespace Anax\View;

?>
<h1>Result</h1>

<p>Result av validering</p>

<div class="ip-result <?= $isValid ? "valid" : "" ?>">

<?php if ($isValid) : ?>
    <p><code><?= htmlentities($ipAddress) ?></code> är en validerad IP Address</p>
<?php else : ?>
    <p><code><?= htmlentities($ipAddress) ?></code> är inte en validerad IP Address</p>
<?php endif; ?>

<?php if ($protocol) : ?>
  <p><strong>Protokoll:</strong> <?= $protocol ?></p>
<?php endif; ?>

<?php if ($domain) : ?>
  <p><strong>Domän:</strong> <?= $domain ?></p>
<?php endif; ?>

<?php if ($country) : ?>
  <p><strong>Land:</strong> <?= $country ?></p>
<?php endif; ?>

<?php if ($region) : ?>
  <p><strong>Region:</strong> <?= $region ?></p>
<?php endif; ?>

<?php if ($city) : ?>
  <p><strong>Stad:</strong> <?= $city ?></p>
<?php endif; ?>

<?php if ($latitude && $longitude) : ?>
  <p><strong>Position:</strong> Longitude: <?= $longitude ?>, Latitude: <?= $latitude ?></p>
  
  <p style="display: none;" id="longitude"><?= $longitude ?></p>
  <p style="display: none;" id="latitude"><?= $latitude ?></p>

  <div style="height: 400px;" id="map"></div>

<link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css">
<script src='https://unpkg.com/leaflet@1.3.3/dist/leaflet.js'></script>
<script type="text/javascript">

var longitude = document.getElementById('longitude').innerText;
var latitude = document.getElementById('latitude').innerText;

var map = L.map('map').setView([latitude, longitude], 11);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([latitude, longitude]).addTo(map)
    .openPopup();
</script>
</div>
<?php endif; ?>

<p><a href="./ipcheck">Rensa resultat</a></p>
