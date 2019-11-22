<?php
namespace Anax\View;

?>
<h1>Senaste 30 dagar</h1>

<div class="weather-result">
<?php if ($weatherinfo) : ?>
    <?php foreach ($weatherinfo as $key => $row) :
            echo "<div class='weather-item col-lg-2 col-md-6'>";
            echo "<div><h4>" . date('d/m', $row["time"]) . "</h4></div>";
            echo "<div><h1>" . round($row["apparentTemperatureHigh"]) . "°C" . "</h1></div>";
            echo "<div class='weather-min-max'><p>" . "Min " . round($row["temperatureMin"]) . "°C" . "</p>";
            echo "<p>" . "Max " . round($row["temperatureMax"]) . "°C" . "</p></div>";
            echo "<div><p><strong>" . $row["windSpeed"] . " m/s</strong></p></div>";
            echo "<div><p>" . $row["summary"] . "</p></div>";
            echo "</div>";
    endforeach; ?>
<?php endif; ?>
<div>