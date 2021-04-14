<?php

/**
 * @var int $userAgencyId
 * @var int $counter
 */

$userAgency = user_agency_peer::instance()
    ->get_item($userAgencyId);

$name = $userAgency['name'];
if ($userAgency['agency_id'] > 0) {
    $agency = agency_peer::instance()
        ->get_item($userAgency['agency_id']);
    $name   = sprintf('<a href="/agency/?id=%s">%s</a>', $agency['id'], $agency['name']);
}

$type         = (int)$userAgency['type'];
$contract     = (int)$userAgency['contract'];
$contractType = (int)$userAgency['contract_type'];

$geo = [];
if (0 !== (int)$userAgency['city_id']) {
    $geo[] = -1 !== $userAgency['city_id']
        ? geo_peer::instance()
            ->get_city($userAgency['city_id'])
        : $userAgency['city'];
}
if ((int)$userAgency['country_id'] > 0) {
    $geo[] = geo_peer::instance()
        ->get_country($userAgency['country_id']);
}

$label = 'Материнское';
if ((bool)$userAgency['foreign_agency']) {
    $label = 'Иностранное';
    if (count($geo) > 0) {
        $name = sprintf('%s <span class="text-muted"> / %s</span>', $name, implode(' / ', $geo));
    }
}

if (empty($name)) {
    return;
}

$modelProfile = '';
if (!empty($userAgency['profile'])) {
    $modelProfile = sprintf(
        '<a href="%s" target="_blank" class="btn-link ml-1 underline" style="color: #FF6A9A">Портфолио</a>',
        $userAgency['profile']
    );
}

?>
<div style="height: 21px">
    <span class="fs12"><?= $name ?></span>
    <?= $modelProfile ?>
    <?php if (1 === $contract) { ?>
        <br/>
        <span class="text-muted"><?= t(user_agency_peer::CONTRACT_TYPES[$contractType]) ?> <?= t('контракт') ?></span>
    <?php } ?>
</div>
