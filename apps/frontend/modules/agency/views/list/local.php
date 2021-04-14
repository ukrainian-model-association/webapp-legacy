<div class="small-title square_p font-weight-bold text-uppercase text-dar mt-3">
    <?= t('Украинские агенства') ?> | INSTAGRAM
</div>

<div class="agency_index">
    <?= implode(
            PHP_EOL,
            array_map(
                    static function ($city) {
                        $agencies = implode(
                                PHP_EOL,
                                array_map(
                                        static function ($agency) {
                                            $membersCount = static function ($agency) {
                                                if ($agency['members_count'] < 1) {
                                                    return;
                                                }

                                                return <<<HTML
<span class="ml-1 text-pink">{$agency['members_count']}</span>
HTML;
                                            };

                                            return <<<HTML
<li class="p-0">
    <h6 class="m-0" style="width: 100%; font-size: 95%; cursor: pointer">
        <a href="/agency/?id={$agency['id']}" class="text-muted" style="font-size: 14px">{$agency['name']}</a>
        {$membersCount($agency)}
    </h6>
</li>
HTML;
                                        },
                                        $city['agencies']
                                )
                        );

                        return <<<HTML
<div class="agency-group">
    <h3 class="p-0 m-0 mb-2 text-nowrap"><span class="text-uppercase h6">{$city['name']}</span></h3>
    <ul class="ml-2">{$agencies}</ul>
</div>
HTML;

                    },
                    $context
            )
    ) ?>
</div>
<style>
    .agency_index {
        -moz-column-count: 3;
        -webkit-column-count: 3;
        column-count: 3;
        width: 100%;
    }
</style>

