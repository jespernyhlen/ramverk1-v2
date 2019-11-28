<?php
namespace Anax\View;

?>
<h1>Plats</h1>

<div class="ip-result">

<?php if ($location["location_summary"]) : ?>
  <p><strong>Plats:</strong> <?= $location["location_summary"] ?></p>
<?php endif; ?>

<?php if ($location["latitude"] && $location["longitude"]) : ?>
  <p><strong>Position:</strong> Longitude: <?= $location["longitude"] ?>, Latitude: <?= $location["latitude"] ?></p>
  
  <p style="display: none;" id="longitude"><?= $location["longitude"] ?></p>
  <p style="display: none;" id="latitude"><?= $location["latitude"] ?></p>

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