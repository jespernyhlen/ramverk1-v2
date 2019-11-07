<?php
namespace Anax\View;

?>
<h1>IP Koll</h1>

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
   
</div>
<p><a href="">Tillbaka</a></p>
