<?php

load::app('modules/profy/controller');

/**
 * @property array|mixed list
 * @property string title
 * @property string ul
 */
class profy_index_action extends profy_controller
{
    public function execute()
    {
        $type   = request::get_int('type');
        $status = request::get_int('status');
        $hidden = request::get_int('hidden');

        $this->ul = 'style="display: block; column-count: 5"';
        // $sql    = 'select * from user_auth ua join user_data ud on ua.id = ud.user_id where ud.status = :status order by first_name';

        $sql  = 'select * from user_auth ua join user_data ud on ua.id = ud.user_id where 1 = 1';
        $bind = [];

        if ($type > 0) {
            $sql          = sprintf('%s and ua.type = :type', $sql);
            $bind['type'] = $type;
        }

        if ($status > 0) {
            $sql            = sprintf('%s and ud.status = :status', $sql);
            $bind['status'] = $status;
        }

        $sql = sprintf('%s and ua.hidden = %s', $sql, $hidden > 0 ? 'true' : 'false');

        $sql = sprintf('%s order by last_name', $sql);

        $this->title = $this->getTitle($status);
        $this->list  = db::get_rows($sql, $bind);
    }

    private function getTitle($status)
    {
        switch ($status) {
            case 32:
                return 'Дизайнеры';
            case 33:
                return 'Фотографы';
            case 38:
                return 'Кастинг менеджеры';
            case 42:
                $this->ul = 'class="list-group"';
                return 'Представители модельных агентств';
            default:
                return '';
        }
    }
}