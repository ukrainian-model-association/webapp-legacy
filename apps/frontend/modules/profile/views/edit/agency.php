<?php

load::model("geo");
load::model('agency');

/** @var array $profile */
$countries           = geo_peer::COUNTRY_IDS;
$cities              = agency_peer::instance()->getCities(geo_peer::UKRAINE);
$user_agency_id      = user_agency_peer::instance()->get_list(['user_id' => $profile['user_id'], 'foreign_agency' => 0]);
$user_agency         = user_agency_peer::instance()->get_item($user_agency_id[0]);
$ufaIds              = user_agency_peer::instance()->get_list(['user_id' => $profile['user_id'], 'foreign_agency' => 1], [], ['id ASC']);
$user_foreign_agency = user_agency_peer::instance()->get_item($ufaIds[0]);

?>

<div class="card fs14" id="profile-edit-frame-agency">
    <form action="/api/profiles/<?= $profile['user_id'] ?>/agencies" method="POST" name="user_agency">
        <div class="card-body">
            <div class="container">
                <div class="row">

                    <div class="col-10 offset-1">

                        <h6 class="card-title">Украинское агентство</h6>

                        <div class="form-row align-items-center">
                            <div class="col-3 text-right">Город:</div>
                            <div class="col">
                                <label class="w-100 m-0">
                                    <select name="uua[city]" class="custom-select custom-select-sm w-100">
                                        <option selected value="0">&mdash;</option>
                                        <?php foreach ($cities as $city) { ?>
                                            <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </div>
                            <div class="col-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" name="uua[​​visibility_area]" type="checkbox" id="​​visibilityArea">
                                    <label class="custom-control-label" for="​​visibilityArea">Просмотр доступен для всех</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <label class="col-3 text-right">Название:</label>
                            <div class="col">
                                <label class="w-100 m-0">
                                    <select name="uua[id]" class="custom-select custom-select-sm w-100">
                                        <option value="0">&mdash;</option>
                                    </select>
                                    <input type="text" name="uua[name]" class="form-control"/>
                                </label>
                            </div>
                        </div><!-- uua[id] -->
                        <div class="form-row mt-2">
                            <div class="col-9 offset-3">
                                <label>
                                    <input type="radio" name="mother_agency[]" value="-1" <?php if ($user_agency['type']){ ?>checked<?php } ?>/>
                                    Материнское агентство
                                </label>
                            </div>
                        </div><!-- uua[mother_agency][] -->
                        <div class="form-row mt-1">
                            <label class="col-3 col-form-label text-right">Страница модели:</label>
                            <div class="col pt-1">
                                <label class="w-50">
                                    <input type="text" name="uua[profile]" class="form-control"/>
                                </label>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <label class="col-3 col-form-label text-right">Контракт:</label>
                            <div class="col pt-2">
                                <label class="mr-2">
                                    <input type="radio" name="uua[contract]" value="0"/>
                                    &mdash;
                                </label>
                                <label class="mr-2">
                                    <input type="radio" name="uua[contract]" value="1"/>
                                    Да
                                </label>
                                <label class="mr-2">
                                    <input type="radio" name="uua[contract]" value="-1"/>
                                    Нет
                                </label>
                            </div>
                        </div><!-- uua[contract] -->
                        <div class="form-row mt-2">
                            <label class="col-3 col-form-label text-right">Тип контракта:</label>
                            <div class="col pt-2">
                                <label>
                                    <input type="radio" name="uua[contract_type]" value="0"/>
                                    &mdash;
                                </label><br/>
                                <label>
                                    <input type="radio" name="uua[contract_type]" value="1"/>
                                    Эксклюзивный
                                </label><br/>
                                <label>
                                    <input type="radio" name="uua[contract_type]" value="-1"/>
                                    Неэксклюзивный
                                </label>
                            </div>
                        </div><!-- uua[contract_type] -->
                    </div>
                </div>
            </div>

            <div class="container mt-3">
                <div class="row">
                    <div class="col-8 offset-1">
                        <h6 class="card-title">Иностранное агентство:</h6>
                    </div>
                </div>
                <template id="foreign_agency">
                    <div class="row" rel="section">
                        <div class="col-8 offset-1">
                            <div class="form-row">
                                <span class="col-3 col-form-label text-right">Страна:</span>
                                <div class="col-5 pt-1">
                                    <label class="w-100">
                                        <select name="ufa[0][country]" class="custom-select custom-select-sm w-100">
                                            <option value="0">&mdash;</option>
                                            <?php foreach ($countries as $country) { ?>
                                                <option value="<?= $country ?>"><?= geo_peer::instance()->get_country($country) ?></option>
                                            <?php } ?>
                                        </select>
                                    </label>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="close float-left" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-row mt-1">
                                <span class="col-3 col-form-label text-right">Город:</span>
                                <div class="col-5 pt-1">
                                    <label class="w-100">
                                        <select name="ufa[0][city]" class="custom-select custom-select-sm w-100">
                                            <option value="0">&mdash;</option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="form-row mt-1">
                                <span class="col-3 col-form-label text-right">Название:</span>
                                <div class="col-5 pt-1">
                                    <label class="w-100">
                                        <select name="ufa[0][id]" class="custom-select w-75">
                                            <option value="0">&mdash;</option>
                                        </select>
                                        <input type="text" name="ufa[0][name]" value="<?= $user_foreign_agency['name'] ?>" class="w-75">
                                    </label>
                                </div>
                            </div>

                            <div class="form-row mt-1">
                                <span class="col-3 col-form-label text-right">Страница модели:</span>
                                <div class="col-5 pt-1">
                                    <label class="w-100">
                                        <input type="text" name="ufa[0][profile]" value="<?= $user_foreign_agency['profile'] ?>" class="w-75">
                                    </label>
                                </div>
                            </div>

                            <div class="form-row mt-2 mb-3">
                                <div class="col-8 offset-3">
                                    <label class="w-100">
                                        <input type="radio" name="mother_agency[]" value="1"/>
                                        Материнское агентство
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <div class="row">
                    <div class="col-8 offset-1">
                        <div class="form-row mt-2">
                            <div class="col-9 offset-3">
                                <input type="button" id="add_foreign_agency" value="Добавить ещё агентство">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <div class="container">
                <div class="row">
                    <div class="col-8 offset-1">
                        <div class="form-row">
                            <div class="col-2 offset-3">
                                <input type="submit" value="Сохранить">
                            </div>
                            <div class="col pt-1">
                                <span class="text-success">Данные сохранены успешно</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="application/javascript" src="https://f.models.org.ua/public/js/lib/profile_edit_agency.js"></script>
<script type="application/javascript">
    window['form[name="user_agency"]'].run({
        user_id: <?= $profile['user_id'] ?>,
        city: <?= $user_agency['city_id'] ?: 0 ?>,
        id: <?= $user_agency['agency_id'] ?: 0 ?>,
        name: '<?= $user_agency['name'] ?>',
        mother_agency: <?=$user_agency['type'] ?: 0?>,
        profile: "<?=$user_agency['profile'] ?: ''?>",
        contract: <?=$user_agency['contract'] ?: 0?>,
        contract_type: <?=$user_agency['contract_type'] ?: 0?>,
        ufa: <?= json_encode(
            array_map(
                static function ($id) {
                    $ufa = user_agency_peer::instance()->get_item($id);

                    return [
                        'country'       => $ufa['country_id'] ?: 0,
                        'city'          => $ufa['city_id'] ?: 0,
                        'id'            => $ufa['agency_id'] ?: 0,
                        'name'          => $ufa['name'] ?: '',
                        'profile'       => $ufa['profile'],
                        'mother_agency' => $ufa['type'] ?: 0,
                    ];
                },
                $ufaIds
            )
        ) ?>

    });


    // $(document).ready(function () {
    //     var form = new Form("profile-edit-form-agency");
    //     form.onSuccess = function (data) {
    //         if (data.success)
    //             $("#msg-success-agency")
    //                 .show()
    //                 .css("opacity", "0")
    //                 .animate({
    //                     "opacity": "1"
    //                 }, 256, function () {
    //                     setTimeout(function () {
    //                         $("#msg-success-agency").animate({
    //                             "opacity": "0"
    //                         }, 256, function () {
    //                             $(this).hide();
    //                         })
    //                     }, 1000);
    //                 });
    //     }
    //     $("#profile-edit-form-agency #submit").click(function () {
    //         form.send();
    //     });
    // })
</script>


