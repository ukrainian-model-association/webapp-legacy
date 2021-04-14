<?php

return static function ($personId) {
    $countries = implode(
        PHP_EOL,
        array_map(
            static function ($country) {
                return sprintf('<option value="%s">%s</option>', $country['country_id'], $country['name']);
            },
            geo_peer::instance()->get_countries()
        )
    );

    return <<<HTML
<form action="/api/profiles/{$personId}/work_place" method="post" name="work_place" onsubmit="return false;">
    <div class="card w-100">
        <div class="card-header">
            <h5 class="card-title m-0">Место работы</h5>
        </div>
        <div class="card-body">

            <div class="form-row align-items-baseline">
                <div class="col-1 offset-2 text-right">Страна:</div>
                <div class="col-3">
                    <label class="w-100">
                        <select name="work_place[country]" class="form-control form-control-sm">
                            <option value="0">-</option>
                            {$countries}
                        </select>
                    </label>
                </div>
            </div>

            <div class="form-row align-items-baseline mt-1">
                <div class="col-1 offset-2 text-right">Журнал:</div>
                <div class="col-3">
                    <label class="w-100">
                        <select name="work_place[journal]" class="form-control form-control-sm"></select>
                    </label>
                </div>
            </div>

            <div class="form-row align-items-baseline mt-1">
                <div class="col-1 offset-2 text-right">Должность:</div>
                <div class="col-3">
                    <label class="w-100">
                        <select name="work_place[position]" class="form-control form-control-sm">
                            <option value="0">-</option>
                            <option value="1">Главный редактор</option>
                            <option value="2">Fashion редактор</option>
                            <option value="3">Fashion журналист</option>
                        </select>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-row align-items-baseline">
                <div class="col offset-3" style="max-width: 150px !important;">
                    <button class="btn btn-sm btn-dark w-100" type="submit">
                        <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true" style="display: none"></span>
                        Сохранить
                    </button>
                </div>
                <div class="col">
                    <p class="text-success m-0 p-0 d-none">Сохранено успешно</p>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="application/javascript" src="/public/js/app/profile/edit/work_place.js"></script>
HTML;
};