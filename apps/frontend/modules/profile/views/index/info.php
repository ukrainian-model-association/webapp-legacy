<?php

/**
 * @var int $user_id
 * @var array $profile
 * @var array $user_params
 */

$uid = (int) $user_id;
return;
?>
<div class="container-fluid p-0 mt-3 black fs12 cgray">
    <?php if (2 === $profile['type']) { ?>
        <div class="d-flex">
            <div class="align-text-top" style="width: 35%">
                <span class="cgray">Материнское агенство:</span>
            </div>
            <div class="d-flex flex-column">
                <?php $counter = 0 ?>
                <?= implode(
                        PHP_EOL,
                        array_map(
                                static function ($userAgencyId) use (&$counter) {
                                    ob_start();
                                    include __DIR__.'/info/agency.php';
                                    $counter++;

                                    return ob_get_clean();
                                },
                                user_agency_peer::instance()->get_list(
                                        ['user_id' => $profile['user_id'], 'foreign_agency' => 0]
                                )
                        )
                ) ?>
            </div>
        </div>

        <?php $fa = user_agency_peer::instance()->get_list(
                ['user_id' => $profile['user_id'], 'foreign_agency' => 1]
        ); ?><?php if (count($fa) > 0) { ?>
            <div class="d-flex mt-1">
                <div class="align-text-top" style="width: 35%">
                    <span class="cgray">Иностранное агенство:</span>
                </div>
                <div class="d-flex flex-column">
                    <?php $counter = 0 ?>
                    <?= implode(
                            PHP_EOL,
                            array_map(
                                    static function ($userAgencyId) use (&$counter) {
                                        ob_start();
                                        include __DIR__.'/info/agency.php';
                                        $counter++;

                                        return ob_get_clean();
                                    },
                                    $fa
                            )
                    ); ?>
                </div>
            </div>
        <?php } ?>

        <?php $user_params = profile_peer::instance()->get_params($profile['user_id']); ?>

        <?php if ($user_params['eye_color']) { ?>
            <div class="d-flex mt-1">
                <div class="align-text-top" style="width: 35%">
                    <span class="cgray">Цвет глаз:</span>
                </div>
                <div class="d-flex flex-column">
                    <?= profile_peer::$params['eye_color'][$user_params['eye_color']] ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($user_params['hair_color'] || $user_params['hair_length']) { ?>
            <div class="d-flex mt-1">
                <div class="align-text-top" style="width: 35%">
                    <span class="cgray">Волосы:</span>
                </div>
                <div class="d-flex flex-column">
                    <?php if ($user_params['hair_color']) { ?><?= profile_peer::$params['hair_color'][$user_params['hair_color']] ?><?php } ?><?php if ($user_params['hair_length']) { ?><?php if ($user_params['hair_color']) { ?>, <?= mb_strtolower(
                            profile_peer::$params['hair_length'][$user_params['hair_length']]
                    ) ?><?php } else { ?><?= ucfirst(
                            profile_peer::$params['hair_length'][$user_params['hair_length']]
                    ) ?><?php } ?><?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($work_experience = profile_peer::$additional['work_experience'][$user_additional['work_experience']]) { ?>
            <div class="d-flex mt-1">
                <div class="align-text-top" style="width: 35%">
                    <span class="cgray">Стаж работы:</span>
                </div>
                <div class="d-flex flex-column">
                    <?= $work_experience ?>
                </div>
            </div>
        <?php } ?>

        <?php $he = unserialize($user_additional['higher_education']); ?><?php $study = [
                '',
                t('Дневная'),
                t('Вечерняя'),
                t('Заочная'),
                t('Ускоренная'),
        ]; ?><?php $status = [
                '',
                t('Абитуриент'),
                t('Студент'),
                t('Студент (бакалавр)'),
                t('Студент (магистр)'),
                t('Выпускник (специалист)'),
                t('Выпускник (бакалавр)'),
                t('Выпускник (магистр)'),
        ]; ?><?php if (
                !empty($he[0]['university'])
                && !empty($he[0]['faculty'])
                && $he[0]['study'] > 0
                && $he[0]['status'] > 0
                && $he[0]['entry_year'] > 0
                && $he[0]['ending_year'] > 0
        ) { ?>
            <div class="d-flex mt-1">
                <div class="align-text-top" style="width: 35%">
                    <span class="cgray">Образование:</span>
                </div>
                <div class="d-flex flex-column" style="width: 65% !important;">
                    <?= $he[0]['university'] ?>,
                    <?= $he[0]['faculty'] ?>,
                    <?= mb_strtolower($study[$he[0]['study']]) ?> ф.о.,
                    <?= mb_strtolower($status[$he[0]['status']]) ?>,
                    <?= $he[0]['entry_year'] ?> - <?= $he[0]['ending_year'] ?>
                </div>
            </div>
        <?php } ?>

        <?php //if (session::get_user_id() === $uid /* || session::has_credential('admin') */) { ?>

        <?php if ($user_additional['foreign_work_experience'] > -1) { ?>
            <div class="row mt-3">
                <div class="col-5">Опыт работы за границей:</div>
                <div class="col">
                    <?php if ($user_additional['foreign_work_experience']) { ?>
                        есть
                    <?php } else { ?>
                        нет
                    <?php } ?>
                </div>

            </div>
        <?php } ?>

        <?php if (isset($user_additional['foreign_passport']) && in_array(
                        (int) $user_additional['foreign_passport'],
                        [0, 1, 2]
                )) { ?>
            <div class="row mt-3">
                <div class="col-5">Загранпаспорт:</div>
                <div class="col">
                    <?php if (1 === $user_additional['foreign_passport']) { ?>
                        есть
                    <?php } elseif (0 === $user_additional['foreign_passport']) { ?>
                        нет
                    <?php } else { ?>
                        скоро будет
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($visa = $user_additional['visa']) { ?>
            <div class="row mt-3">
                <div class="col-5">Визы:</div>
                <div class="col"><?= $visa ?></div>
            </div>
        <?php } ?>

        <div class="row mt-3"></div>
        <?php if (4 !== (int) $profile['type'] && $current_work_place_name = $user_additional['current_work_place_name']) { ?>
            <div class="row">
                <div class="col-5">Место работы:</div>
                <div class="col">
                    <?= $current_work_place_name ?>, <?= $user_additional['current_work_place_appointment'] ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($user_additional['marital_status'] > -1) { ?>
            <div class="row mt-3">
                <div class="col-5">Семейное положение:</div>
                <div class="col">
                    <?php if (1 === (int) $user_additional['marital_status']) { ?>
                        Замужем
                    <?php } else { ?>
                        Не замужем
                    <?php } ?>
                    <?php if (1 === (int) $user_additional['kids']) { ?>, есть дети<?php } elseif (0 === $user_additional['kids']) { ?>, <?= t(
                            'детей нет'
                    ) ?><?php } ?>
                </div>
            </div>
        <?php } ?>


        <?php if ($user_additional['smoke'] > -1) { ?>
            <div class="row mt-3">
                <div class="col-5">Курю:</div>
                <div class="col">
                    <?php if (0 !== (int) $user_additional['smoke']) { ?>
                        да
                    <?php } else { ?>
                        нет
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

    <?php } ?>

    <?php if ($user_additional['eng_knowledge'] > 0) { ?>
        <div class="row mt-3">
            <div class="col-5">Уровень знания английского языка:</div>
            <div class="col"><?= profile_peer::$eng_knowledge[$user_additional['eng_knowledge']] ?></div>
        </div>
    <?php } ?>

    <?php $__ud = user_data_peer::instance()->get_item($user_id); ?><?php $__hd = unserialize(
            $__ud['hidden_data']
    ) ?><?php if (!empty($__hd['why'])) { ?>
        <div class="row mt-3">
            <div class="col-5">Почему хотите стать моделью?:</div>
            <div class="col"><?= $__hd['why'] ?></div>
        </div>
    <?php } ?><?php // } ?>
</div>
