<?php

/**
 * This file is part of the modelsua/modelsua package.
 */

use PhpCollection\Set;

load::model('voting');
load::model('date');
load::model('user/user_foreign_works');
load::model('user/user_smi');
load::model('news');
load::app('modules/profile/controller');

/**
 * @property int         user_id
 * @property array       page_position
 * @property array       json
 * @property array       categories
 * @property array       works
 * @property array       albums
 * @property array       hronologies
 * @property array|mixed foreignWorks
 * @property array[]     smi
 * @property array[]     newsSmi
 */
class profile_index_action extends profile_controller
{
    public function execute()
    {
        parent::execute();

        $act = request::get('act');
        if (in_array(
            $act,
            [
                'remove_profile',
                'set_location',
                'foreign_works',
                'remove_foreign_work',
                'to_reserv',
                'from_reserv',
                'add_smi',
                'remove_smi',
            ]
        )) {
            $this->set_renderer('ajax');

            return $this->json['success'] = $this->$act();
        }

        $this->page_position = [
            'position' => 0,
            'page'     => 0,
        ];

        $ua_list = user_auth_peer::instance()->get_list(
            [
                'type'   => 2,
                'hidden' => false,
                'del'    => 0,
                'reserv' => 0,
            ]
        );

        $ud_list = user_data_peer::instance()->get_list([], [], ['rank ASC']);

        $list = [];
        foreach ($ud_list as $ud_item) {
            if (in_array($ud_item, $ua_list, true)) {
                $list[] = $ud_item;
            }
        }

        $cnt = 0;
        foreach ($list as $item) {
            if ($this->user_id === $item) {
                $this->page_position['page']     = ceil($cnt / 24);
                $this->page_position['position'] = $cnt - (($this->page_position['page'] - 1) * 24) + 1;
                break;
            }

            $cnt++;
        }

        $sql = 'SELECT id FROM user_auth WHERE type=:type AND hidden=:hidden AND del=:del AND reserv=:reserv';

        $this->categories = [
            'covers'      => t('Обложки'),
            'fashion'     => t('Fashion stories'),
            'advertising' => t('Реклама'),
            'defile'      => t('Дефиле'),
            'contest'     => t('Конкурсы'),
            'video_adv'   => t('Видеореклама'),
            'catalogs'    => t('Каталоги'),
        ];

        $this->works = user_albums_peer::get_categories();

        $this->albums = [
            'portfolio'     => [],
            'covers'        => [],
            'fashion'       => [],
            'advertisement' => [],
            'defile'        => [],
            'contest'       => [],
            'catalogs'      => [],
            'photos'        => [],
        ];

        $this->smi = array_map(
            static function ($id) {
                $item = user_smi_peer::instance()->get_item($id);

                return [
                    'link'      => $item['link'],
                    'name'      => $item['name'],
                    'protected' => false,
                ];
            },
            user_smi_peer::instance()->get_list(['user_id' => $this->user_id], [], ['id DESC'])
        );

        $this->newsSmi = array_map(
            static function ($id) {
                $item = news_peer::instance()->get_content($id);

                return [
                    'link'      => sprintf('/news/view?id=%s', $id),
                    'name'      => $item['title'],
                    'protected' => true,
                ];
            },
            db::get_cols(
                'select id from news where models ilike \'%s:'.strlen($this->user_id).':"'.$this->user_id.'";%\''
            )
        );

        $this->hronologies = [];

        $sql  = 'SELECT id FROM user_photos WHERE user_id = :user_id AND del > 0';
        $bind = [
            'user_id' => $this->user_id,
        ];

        $this->albums['admin'] = db::get_cols($sql, $bind);

        if (count($this->albums['admin']) > 5) {
            $this->albums['admin'] = array_splice($this->albums['admin'], 0, 5);
        }

        foreach ($this->albums as $category_key => $array) {
            $cond_category = $category_key;

            if ($cond_category === 'photos') {
                $cond_category = '';
            }

            $cond = [
                'user_id'  => $this->user_id,
                'category' => $cond_category,
            ];

            $albums_id = user_albums_peer::instance()->get_list($cond);

            foreach ($albums_id as $album_id) {
                $album               = user_albums_peer::instance()->get_item($album_id);
                $album['images']     = unserialize($album['images']);
                $album['additional'] = unserialize($album['additional']);

                $this->albums[$category_key][] = $album;

                if (in_array($category_key, ['portfolio', 'photos'])) {
                    continue;
                }

                $chronology = [
                    'name'     => '',
                    'category' => '',
                    'month'    => '',
                    'year'     => '',
                ];

                switch ($category_key) {
                    case 'contest':
                        $name = $album['additional']['event_title'];
                        if ($loc = profile_peer::get_location($album['additional'], ', ')) {
                            $name .= ', '.$loc;
                        }
                        $chronology = [
                            'link'     => '/albums/album?aid='.$album['id'].'&uid='.$this->user_id,
                            'name'     => $name,
                            'category' => 'Конкурс',
                            'month'    => $album['additional']['period_month'],
                            'year'     => $album['additional']['period_year'],
                        ];
                        break;

                    case 'catalogs':
                        $chronology = [
                            'link'     => '/albums/album?aid='.$album['id'].'&uid='.$this->user_id,
                            'name'     => $album['additional']['name'],
                            'category' => 'Каталог',
                            'month'    => $album['additional']['period_month'],
                            'year'     => $album['additional']['period_year'],
                        ];
                        break;

                    case 'advertisement':
                        $chronology = [
                            'link'     => '/albums/album?aid='.$album['id'].'&uid='.$this->user_id,
                            'name'     => $album['additional']['brand'],
                            'category' => 'Печатная реклама',
                            'month'    => $album['additional']['period_month'],
                            'year'     => $album['additional']['period_year'],
                        ];
                        break;

                    case 'covers':
                        foreach ($album['images'] as $pid) {
                            $photo               = user_photos_peer::instance()->get_item($pid);
                            $photo['additional'] = unserialize($photo['additional']);

                            $name = $photo['additional']['journal_name'];
                            if ($photo['additional']['journal_number'] > 0) {
                                $name .= ' №'.$photo['additional']['journal_number'];
                            }

                            $chronology = [
                                'link'     => '/albums/album?aid='.$album['id'].'&uid='.$this->user_id.'&show=viewer&pid='.$pid,
                                'name'     => $name,
                                'category' => 'Обложка',
                                'month'    => $photo['additional']['journal_month'],
                                'year'     => $photo['additional']['journal_year'],
                            ];
                            if (0 === $chronology['month'] || 0 === $chronology['year']) {
                                $chronology['month'] = 0;
                                $chronology['year']  = 0;
                            }
                            $chronology['date']  = mktime(
                                0,
                                0,
                                0,
                                intval($chronology['month'] + 1),
                                0,
                                intval($chronology['year'])
                            );
                            $this->hronologies[] = $chronology;
                        }
                        break;

                    case 'fashion':
                        $chronology = [
                            'link'     => sprintf('/albums/album?aid=%s&uid=%d', $album['id'], $this->user_id),
                            'name'     => $album['additional']['journal_name'],
                            'category' => 'Fashion story',
                            'month'    => $album['additional']['journal_month'],
                            'year'     => $album['additional']['journal_year'],
                        ];
                        break;

                    case 'defile':
                        $name = '';
                        if ('' !== $album['additional']['designer']) {
                            $name .= $album['additional']['designer'].', ';
                        }
                        $name .= $album['additional']['event_title'];
                        if ($loc = profile_peer::get_location($album['additional'], ', ')) {
                            $name .= ', '.$loc;
                        }
                        $chronology = [
                            'link'     => sprintf('/albums/album?aid=%s&uid=%d', $album['id'], $this->user_id),
                            'name'     => $name,
                            'category' => 'Показ',
                            'month'    => $album['additional']['period_month'],
                            'year'     => $album['additional']['period_year'],
                        ];
                        break;
                }

                if ('covers' !== $category_key) {
                    if (0 === $chronology['month'] || 0 === $chronology['year']) {
                        $chronology['month'] = 0;
                        $chronology['year']  = 0;
                    }
                    $chronology['date']  = mktime(
                        0,
                        0,
                        0,
                        $chronology['month'] + 1,
                        0,
                        $chronology['year']
                    );
                    $this->hronologies[] = $chronology;
                }
            }

            usort($this->hronologies, [$this, 'chronology_sorting']);
        }

        $this->foreignWorks = user_foreign_works::instance()->get_list(
            ['user_id' => $this->user_id],
            [],
            ['from_ts DESC']
        );

        return true;
    }

    public function chronology_sorting($x, $y)
    {
        return $x['date'] < $y['date'];
    }

    private function set_location()
    {
        $uid = request::get_int('id');

        $data = [
            'user_id'      => $uid,
            'country'      => request::get_int('country'),
            'region'       => request::get_int('region'),
            'city'         => request::get_int('city'),
            'another_city' => request::get_string('another_city'),
        ];

        user_data_peer::instance()->update($data);

        $this->json['location'] = profile_peer::get_location($data);

        return true;
    }

    private function remove_profile()
    {
        $data = [
            'id'  => request::get_int('id'),
            'del' => time(),
        ];
        user_auth_peer::instance()->update($data);
        profile_peer::instance()->del_hist_push(
            [
                'user_id' => $data['id'],
                'act'     => 'in_archive',
            ]
        );

        return true;
    }

    private function foreign_works()
    {
        $uid = request::get_int('id');

        $data = [
            'user_id'          => $uid,
            'company_name'     => stripslashes(request::get_string('company_name')),
            'country'          => request::get_int('country'),
            'region'           => request::get_int('region'),
            'city'             => request::get_int('city'),
            'another_city'     => request::get_string('another_city'),
            'from_ts'          => date(
                'Y-m-d h:i:s',
                mktime(0, 0, 0, request::get_int('from_month'), 1, request::get_int('from_year'))
            ),
            'to_ts'            => date(
                'Y-m-d h:i:s',
                mktime(0, 0, 0, request::get_int('to_month'), 1, request::get_int('to_year'))
            ),
            'work_description' => stripslashes(request::get_string('work_description')),
        ];

        if ('' === $data['company_name']) {
            $this->json['error'] = '0';

            return false;
        }

        if ($data['country'] < 1) {
            $this->json['error'] = '1';

            return false;
        }

        if (0 === $data['city'] || (-1 === $data['city'] && '' === $data['another_city'])) {
            $this->json['error'] = '2';

            return false;
        }

        if (!$ufwId = user_foreign_works::instance()->insert($data)) {
            $this->json['error'] = '3';

            return false;
        }

        header('Location: /profile?id='.$uid);

        return $ufwId;
    }

    private function remove_foreign_work()
    {
        $ufwId               = request::get_int('ufwId');
        $this->json['ufwId'] = $ufwId;
        user_foreign_works::instance()->delete_item($ufwId);

        return true;
    }

    private function to_reserv()
    {
        $cond = [
            'id'     => request::get_int('id'),
            'del'    => 0,
            'reserv' => time(),
        ];
        user_auth_peer::instance()->update($cond);

        return true;
    }

    private function from_reserv()
    {
        $cond = [
            'id'     => request::get_int('id'),
            'reserv' => 0,
        ];
        user_auth_peer::instance()->update($cond);

        return true;
    }

    private function add_smi()
    {
        $uid  = request::get_int('id');
        $name = request::get_string('name');
        $link = request::get_string('link');

        if (false === strpos($link, 'https://')) {
            $link = 'https://'.$link;
        }

        $data = [
            'user_id' => $uid,
            'name'    => $name,
            'link'    => $link,
        ];

        user_smi_peer::instance()->insert($data);

        return true;
    }

    private function remove_smi()
    {
        $uid    = request::get_int('id');
        $smi_id = request::get_string('smi_id');

        user_smi_peer::instance()->delete_item($smi_id);

        return true;
    }
}
