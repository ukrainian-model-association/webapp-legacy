<?php

use App\Component\Asset\AssetFactory;

/** @var AssetFactory $assets */

?>

<?= $assets->script('https://www.google.com/recaptcha/api.js?render=6LdO1MUUAAAAAPeYMtLpiZdoJVXwq-jEXhXpp6oM') ?>
<script>
  window.grecaptcha.ready(function () {
    window.grecaptcha.execute('6LdO1MUUAAAAAPeYMtLpiZdoJVXwq-jEXhXpp6oM', { action: 'homepage' })
  })
</script>
