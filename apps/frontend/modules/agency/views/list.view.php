<?php
/**
 * @var string $tab
 */
?>


<div class="mt-3 mb-0 font-weight-bold text-uppercase d-none">
    <a href="?tab=local" <?= 'local' === $tab ? 'class="btn badge px-3 py-2 badge-dark text-white"' : '' ?>>Украинские агенства</a> |
    <a href="?tab=foreign" <?= 'foreign' === $tab ? 'class="btn badge px-3 py-2 badge-dark text-white"' : '' ?>>Иностранные агенства</a>
</div>
<?php include __DIR__.'/list/'.$tab.'.php' ?>
<style type="text/css">
    .agency-group {
        -webkit-column-break-inside: avoid;
        page-break-inside: avoid;
        /*break-inside: avoid;*/
        break-inside: avoid-column;
        display: table;
    }

    .text-pink {
        color: #ff6a9a;
    }
</style>
