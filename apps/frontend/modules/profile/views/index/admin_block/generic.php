<div class="row">
    <div class="col">
        <table class="w-100">

            <?php if (!$profile['email'] && $profile['security']) { ?>
                <tr>
                    <td>
                        <div class="fs12">
                            <br/><b><?= t('Ccылка для приглашения') ?>:</b><br/>
                            <a href="https://<?= conf::get('server') ?>/profile?code=<?= $profile['security'] ?>">
                                https://<?= conf::get('server') ?>/profile?code=<?= $profile['security'] ?>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            <tr class="d-none">
                <td>
                    <br/><b><?= t('Cкрытый') ?>:</b><br/>
                    <input type="radio" class="left" name="additional-hidden-change[]" value="1" <?= ($profile['hidden']) ? ' checked' : ' ' ?>><label
                            class="left"><?= t('Да') ?></label>
                    <input type="radio" class="left ml10" name="additional-hidden-change[]" value="0" <?= (!$profile['hidden']) ? ' checked'
                        : ' ' ?>><label class="left"><?= t('Нет') ?></label>
                </td>
            </tr>
            <tr  class="d-none">
                <td>
                    <br/><b><?= t('Может переписываться') ?>:</b><br/>
                    <input type="radio" class="left" name="additional-can_write-change[]" value="1" <?= ($profile['can_write']) ? ' checked'
                        : ' ' ?>><label class="left"><?= t('Да') ?></label>
                    <input type="radio" class="left ml10" name="additional-can_write-change[]" value="0" <?= (!$profile['can_write']) ? ' checked'
                        : ' ' ?>><label class="left"><?= t('Нет') ?></label>
                </td>
            </tr>
            <tr class="d-none">
                <td>
                    <br/><b><?= t('Статус') ?>:</b><br/>
                    <select id="additional-status_change-<?= $profile['user_id'] ?>" class="left" style="width: 200px;">
                        <?php
                        $statuses = profile_peer::get_types_list();
                        echo '<optgroup label='.t('Статус не назначен').' value="0">';
                        echo '<option value="0" selected>&mdash;</option></optiongroup>';
                        foreach ($statuses as $key => $value) {
                            echo '<optgroup label="'.$value['type'].'" value="'.$key.'">';
                            if (is_array($value['status'])) {
                                foreach ($value['status'] as $k => $v) {
                                    echo '<option value="'.$k.'" '.(profile_peer::get_status_by_user($profile['user_id']) == $k ? ' selected' : '')
                                        .'>'.(t($v) ? t($v) : t($value['type'])).'</option>';
                                }
                            }
                            echo '</optgrtrue';

                        }
                        ?>
                    </select>
                    <img src="/ui/wait.gif" strue="width: 20px;" class="hide left" id="wait-image-<?= $profile['user_id'] ?>"/>
                </td>
            </tr>
            <tr id="block-agency" class="<?php if ($profile['status'] != 42) { ?>hide<?php } ?>">
                <td>
                    <select id="agency" style="width: 200px;">
                        <option value="0">&mdash;</option>
                        <?php $agency_list = agency_peer::instance()->get_list(['public' => 1, 'page_active' => true], [], ['id ASC']) ?>
                        <?php foreach ($agency_list as $agency_id) { ?>
                            <?php $agency = agency_peer::instance()->get_item($agency_id); ?>
                            <option value="<?= $agency['id'] ?>"><?= $agency['name'] ?></option>
                        <?php } ?>
                    </select>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#agency').val(<?=$profile['manager_agency_id']?>);

                            $('#agency').change(function () {
                                $.post('/adminka/umanager', {
                                    'act': 'set_agency',
                                    'user_id': '<?=$profile['user_id']?>',
                                    'agency_id': $(this).val()
                                }, function (response) {
                                    console.log(response);
                                }, 'json');
                            });
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <td>
                    <br/>
                    <b>Откуда узнала:</b> <?= $learned_about ?>
                </td>
            </tr>
            <tr>
                <td>
                    <br/>
                    <?php if ($profile['registrator'] > 0) { ?>
                        <?php $registrator = profile_peer::instance()->get_item($profile['registrator']); ?>
                        <b>Зарегистрировал:</b> <a href="/profile?id=<?= $profile['registrator'] ?>"><?= profile_peer::get_name($registrator) ?></a>
                    <?php } else { ?>
                        <b>Саморегистрация</b>
                    <?php } ?>
                    <?php if ($profile['created_ts'] > 0) { ?><?= date('d.m.Y h:s', $profile['created_ts']) ?><?php } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <br/>
                    <?php if ($profile['active']) { ?><b>Активная</b><?php } else { ?><b>Неактивная</b><?php } ?>
                    <?php if ($profile['activated_ts'] > 0) { ?><?= date('d.m.Y h:s', $profile['activated_ts']) ?><?php } ?>
                </td>
            </tr>

            <tr>
                <td>
                    <b><?= t('Позиция в каталоге') ?>:</b> <?= $page_position['page'] ?> <?= t('страница') ?>
                    , <?= $page_position['position'] ?> <?= t('позиция') ?>
                </td>
            </tr>
        </table>
    </div>

    <div class="col-5">
        <div class="row">
            <div class="col">
                <div class="h6"><?= t('Этапы взаимодействия') ?></div>
                <div aria-label="" class="btn-group" id="milestone" role="group">
                    <?= implode(
                        PHP_EOL,
                        array_map(
                            static function ($value, $text) {
                                return sprintf(
                                    '<button class="btn btn-sm btn-outline-dark" type="button" value="%s">%s</button>',
                                    $value,
                                    null !== $text ? $text : $value
                                );
                            },
                            range(0, 5),
                            ['-']
                        )
                    ) ?>
                </div>

                <script type="application/javascript">
                    (selectors => {
                        const $object2FormData = (() => {
                            const object2FormData = (formData, data, parentKey) => {
                                if (data && typeof data === 'object' && !(data instanceof Date)) {
                                    Object.keys(data).forEach(key => {
                                        object2FormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                                    });
                                } else {
                                    const value = data == null ? '' : data;

                                    formData.append(parentKey, value);
                                }

                                return formData;
                            };

                            return object2FormData;
                        })();

                        const $fetch = (() => {
                            const headers = new Headers({
                                Accept: '*/*',
                                'Access-Control-Allow-Methods': 'GET, POST, OPTIONS, PUT, PATCH, DELETE',
                                'Access-Control-Allow-Headers': 'origin,X-Requested-With,content-type,accept',
                                'Access-Control-Allow-Credentials': 'true'

                            });

                            return (method, url, body) => {
                                return fetch(url, { method, headers, body: $object2FormData(new FormData, body) })
                                    .then(response => response.json());
                            }
                        })();

                        const buttonsGroup = document.querySelector(selectors),
                              buttons      = buttonsGroup.querySelectorAll(':scope > button.btn'),
                              handleClick  = ({ target: { classList, value } }) => {
                                  $fetch('POST', '/api/profiles/<?=$profile['user_id']?>/milestones', {
                                      milestone: value
                                  }).then(r => {
                                      classList.remove('btn-outline-secondary');
                                      classList.add('btn-secondary');
                                  });

                                  buttons.forEach(({ classList }) => {
                                      classList.remove('btn-secondary');
                                      classList.add('btn-outline-secondary');
                                  });
                              };

                        buttons.forEach(b => {
                            b.addEventListener('click', handleClick);
                        });


                    })('div#milestone.btn-group');
                </script>
            </div>
            <?php if(null !== $profile['milestone']) { ?>
                buttons.item(<?=$profile['milestone']?>).click();
            <?php } ?>
        </div>
    </div>
</div>