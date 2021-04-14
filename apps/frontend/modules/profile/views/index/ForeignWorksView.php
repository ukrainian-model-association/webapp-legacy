<?php

/**
 * This file is part of the modelsua/modelsua package.
 */

use App\Component\AbstractView;
use App\Component\Asset\Asset;
use App\Component\Asset\AssetManager;
use App\Component\Asset\AssetTypes;
use App\Component\ServiceContainer;
use App\Component\UI\UI;

/**
 * Class ForeignWorksView
 */
class ForeignWorksView extends AbstractView
{
    /** @var array */
    private $ctx;

    /** @var ServiceContainer */
    private $box;

    /** @var AssetManager */
    private $manager;

    public function willMount(array $ctx, ServiceContainer $box)
    {
        $this->ctx     = $ctx;
        $this->box     = $box;
        $this->manager = $box->get(AssetManager::class);

        $asset = new Asset();
        $asset
            ->setType(AssetTypes::JAVASCRIPT)
            ->setUrl('/public/js/app/profile/index/foreign_works.js');

        $this->manager->bind($asset);
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        // if (4 !== session::get_user_id()) {
        //     return null;
        // }

        $ctx = $this->ctx;
        $di  = $this->box;

        /** @var UI $ui */
        $ui      = $di->get('ui');
        $content = $this->renderContent($this->ctx['foreignWorks']);
        $profile = $ctx['profile'];

        if (profile_peer::MODEL_TYPE !== profile_peer::get_type_by_user($profile['user_id']) && 4 !== session::get_user_id()) {
            return null;
        }

        $userId = (int) $profile['user_id'];
        $year   = (int) date('Y');

        $context = [
            'title'   => 'Контракты',
            'content' => "<ul class=\"list-group list-group-flush\">{$content}</ul>",
        ];
        $options = [
            'class'          => 'mt-4',
            'header_buttons' => [
                $this->addForeignWorkButton(),
            ],
        ];

        return <<<TAG
<section id="foreignWorks" data-profile-id="{$userId}">
    <div class="position-relative">
        {$this->renderForeignWorkFormView($userId, $year)}
    </div>
    {$ui->render('layout/panel', $context, $options)}
</section>
TAG;
    }

    private function renderContent($data)
    {
        if (!(count($data) > 0)) {
            return $this->box->get('ui')->render('bootstrap/alert', 'Тут еще нет работ');
        }

        return implode(
            PHP_EOL,
            array_map(
                static function ($id) {
                    $foreignWork = user_foreign_works::instance()->get_item($id);
                    $location    = profile_peer::get_location($foreignWork);

                    return <<<HTML
<li class="list-group-item p-0" data-key="{$foreignWork['id']}">
    <div class="align-items-center" style="display: grid; grid-template-columns: auto minmax(50px, auto)">
        <div>
            <div>{$location} :: {$foreignWork['company_name']}</div>
            <small class="text-muted">{$foreignWork['from_month']}, {$foreignWork['from_year']} - {$foreignWork['to_month']}, {$foreignWork['to_year']}</small>
        </div>
        <div class="text-right">
<!--            <a onclick="profile.foreignWorks.editForeignWork({$foreignWork['id']}, this);" class="material-icons" style="font-size: large" href="javascript:void(0);">edit</a>-->
            <a onclick="profile.foreignWorks.deleteForeignWork({$foreignWork['id']}, this)" class="material-icons" style="font-size: large" href="javascript:void(0);">delete_forever</a>
        </div>
    </div>
</li>
HTML;

                    return <<<HTML
<div id="foreign_work-{$foreignWork['id']}" class="fs12 my-2">
    <div>
        <div class="left" style="width: 200px">
            <div>{$location} :: {$foreignWork['company_name']}</div>
        </div>
        <div class="right">
            <button class="btn btn-link">
                <span class="material-icons">delete_forever</span>
            </button>
        </div>
        <div class="right aright cgray" style="width: 200px;">
            {$foreignWork['from_month']}, {$foreignWork['from_year']} - {$foreignWork['to_month']}, {$foreignWork['to_year']}
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="fs11 cgray">{$foreignWork['work_description']}</div>
<hr style="border: none; border-top: 1px solid #ccc">
HTML;
                },
                $data
            // array_merge($data, $data, $data)
            )
        );
    }

    private function addForeignWorkButton()
    {
        return '<a class="cgray" href="javascript:profile.foreignWorks.createForeignWork();">Добавить работу</a>';
    }

    /**
     * @param int    $userId
     * @param int    $year
     * @param string $description
     *
     * @return string
     */
    private function renderForeignWorkFormView($userId, $year, $description = '')
    {
        $countries = implode(
            PHP_EOL,
            array_map(
                static function ($entry) {
                    return sprintf('<option value="%s">%s</option>', $entry['country_id'], $entry['name_ru']);
                },
                geo_peer::instance()->get_countries()
            )
        );

        return <<<UI
<div class="card shadow-lg bg-white border-dark rounded d-none" id="window-foreign_work" style="box-sizing: border-box; position: absolute; z-index: 1; width: 99%; left: 1%">
    <form id="foreign_works" name="foreign_work">
    
        <input type="hidden" id="id" name="foreign_work[id]"/>
        <input type="hidden" name="foreign_work[user_id]" value="{$userId}"/>
    
        <div class="card-body">
            <div class="form-group row align-items-center">
                <label class="d-none" for="country"></label>
                <div class="col">
                    <select id="country" name="foreign_work[country]" class="custom-select custom-select-sm w-100">
                        <option selected disabled value="0">- Страна -</option>
                        {$countries}
                    </select>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label class="d-none" for="city"></label>
                <div class="col">
                    <select id="city" name="foreign_work[city]" class="custom-select custom-select-sm w-100">
                        <option selected disabled value="0">- Город -</option>
                    </select>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label class="d-none" for="company_name"></label>
                <div class="col">
                    <select id="company_name" name="foreign_work[agency_id]" class="custom-select custom-select-sm w-100">
                        <option selected disabled value="0">- Агентство -</option>
                    </select>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <div class="col pr-0">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend text-right" style="width: 40px">
                            <label class="input-group-text w-100">С</label>
                        </div>
                        {$this->monthPeriodSelect('foreign_work[from_month]')}
                        <select class="custom-select custom-select-sm" id="from_year" name="foreign_work[from_year]">
                            <option value="0" selected disabled>—</option>
                            {$this->renderYearSelect()}
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend text-right" style="width: 40px">
                            <label class="input-group-text w-100">По</label>
                        </div>
                        {$this->monthPeriodSelect('foreign_work[to_month]')}
                        <select class="custom-select custom-select-sm" id="to_year" name="foreign_work[to_year]">
                            <option value="0" selected disabled>—</option>
                            {$this->renderYearSelect()}
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-start mb-0">
                <label class="d-none" for="description"></label>
                <div class="col">
                        <textarea class="form-control form-control-sm"
                                  id="description"
                                  name="foreign_work[description]"
                                  placeholder="Отзыв"
                                  style="min-height: 100px">{$description}</textarea>
                </div>
            </div>

            <div id="msg-success-foreign_works" class="mt10 text-center hide" style="color: #090;">
                Данные сохранены успешно
            </div>
            <div id="msg-error-foreign_works" class="mt10 text-center hide" style="color: #900;">
                Ошибка: проверьте, все ли данные введены правильно
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col offset-6 text-right">
                    <button class="btn btn-sm btn-secondary text-white mr-1" type="submit">Добавить</button>
                    <button class="btn btn-sm btn-secondary text-white" type="button" onclick="profile.foreignWorks.modal.close()">Отмена</button>
                </div>
            </div>
        </div>
    </form>
</div>
UI;
    }

    private function monthPeriodSelect($id)
    {
        return <<<TAG
<select class="custom-select" id="{$id}" name="{$id}">
    {$this->renderOptionSet(ui_helper::get_mounth_list())}
</select>
TAG;
    }

    private function renderOptionSet($optionMap)
    {
        $options = array_map(
            static function ($text, $value) {
                return sprintf('<option value="%s">%s</option>', $value, $text);
            },
            array_values($optionMap),
            array_keys($optionMap)
        );

        return $this->renderView($options);
    }

    private function renderYearSelect()
    {
        $now   = (int) date('Y');
        $range = range($now, $now - 30);

        $optionMap = [];
        foreach ($range as $year) {
            $optionMap[$year] = $year;
        }

        return $this->renderOptionSet($optionMap);
    }
}

return ForeignWorksView::createView();
