<?php

/**
 * This file is part of the modelsua/modelsua package.
 */

load::model('user/user_auth');
load::model('user/user_data');
load::model('user/profile');
load::model('user/user_albums');
load::view_helper('ui', false);

/**
 * @property array menu_tree
 */
abstract class frontend_controller extends basic_controller
{
    public function pre_init()
    {
        parent::pre_init();
        if ('' === $_GET['module'] && '' !== $_GET['subdomain']) {
            $tokens = db::get_scalar(
                'SELECT COUNT(id) FROM user_data WHERE subdomain = :subdomain',
                ['subdomain' => $_GET['subdomain']]
            );
            if ($tokens > 0) {
                $this->redirect('/profile');
            } else {
                $this->redirect('/agency');
            }
        }
    }

    public function init()
    {
        parent::init();

        profile_peer::instance();
        user_albums_peer::instance();

        if (!session::get_user_id()) {
            if ($uid = cookie::get('uid')) {
                if ($profile = profile_peer::instance()->get_item($uid)) {
                    $credentials = unserialize($profile['credentials']);
                    if (!is_array($credentials)) {
                        $credentials = [];
                    }

                    session::set_user_id($profile['user_id'], unserialize($profile['credentials']));
                    cookie::set('uid', $profile['user_id'], time() + 60 * 60 * 24 * 30, '/', conf::get('server'));
                }
            }
        }

        client_helper::set_title(t('Ассоциация моделей Украины'));

        session::set('language', session::get('language', 'ru'));
        translate::set_lang(session::get('language', 'ru'));

        $this->menu_items = [
            [
                'href'        => '/page?link=about',
                'html'        => t('АМУ'),
                'static_link' => 'about',
            ],
            [
                'href'     => '/people?filter=successful-models',
                'html'     => t('Модели'),
                'children' => ('en' === session::get('language')) ? false : [
                    [
                        'link'  => '/people?filter=successful-models',
                        'title' => serialize([session::get('language') => t('Каталог')]),
                    ],
                    [
                        'link'   => '/profy?type=2',
                        'title'  => serialize([session::get('language') => t('* Список')]),
                        'hidden' => session::has_credential('admin') ? false : true,
                    ],
                    [
                        'link'   => '/profy?type=2&hidden=1',
                        'title'  => serialize([session::get('language') => t('* Cкрытый список')]),
                        'hidden' => session::has_credential('admin') ? false : true,
                    ],
                    [
                        'link'   => '/people',
                        'title'  => serialize([session::get('language') => t('Рейтинг успешных моделей')]),
                        'hidden' => true,
                    ],
                    [
                        'link'   => '/polls/rating?type=1',
                        'title'  => serialize([session::get('language') => t('Рейтинг популярности')]),
                        'hidden' => true,
                    ],
                    [
                        'link'   => '/people',
                        'title'  => serialize([session::get('language') => t('Перспективные модели')]),
                        'hidden' => true,
                    ],
                    [
                        'link'   => '/people',
                        'title'  => serialize([session::get('language') => t('Новые лица')]),
                        'hidden' => true,
                    ],
                    [
                        'link'   => '/search',
                        'title'  => serialize([session::get('language') => t('Поиск')]),
                        'hidden' => session::has_credential('admin') ? false : true,
                    ],
                ],
            ],
            [
                'href'   => '/page?link=for_models',
                'html'   => t('Сервисы'),
                'hidden' => false,
            ],
            [
                'href'     => '/agency/list',
                'html'     => t('Агентства'),
                'children' => [
                    [
                        'link'  => '/agency/list?tab=local',
                        'title' => serialize([session::get('language') => t('Украинские')]),
                    ],
                    [
                        'link'  => '/agency/list?tab=foreign',
                        'title' => serialize([session::get('language') => t('Иностранные')]),
                    ],
                ],
            ],
            [
                'href'     => '#',
                'html'     => t('ПРОФИ'),
                'children' => [
                    [
                        'link'   => '/profy?status=33&hidden=1',
                        'title'  => serialize([session::get('language') => t('Фотографы')]),
                        'hidden' => false,
                    ],
                    [
                        'link'   => '/profy?status=32&hidden=1',
                        'title'  => serialize([session::get('language') => t('Дизайнеры')]),
                        'hidden' => false,
                    ],
                    [
                        'link'   => '/profy?status=42&hidden=1',
                        'title'  => serialize([session::get('language') => t('Представители МА')]),
                        'hidden' => false,
                    ],
                    [
                        'link'   => '/profy?status=38&hidden=1',
                        'title'  => serialize([session::get('language') => t('* Кастинг менеджеры')]),
                        'hidden' => session::has_credential('admin') ? false : true,
                    ],
                ],
            ],
            [
                'href'   => '/journals/list',
                'html'   => t('Журналы'),
                'hidden' => true,
            ],
            [
                'href'        => '/page?link=profession',
                'html'        => t('Полезное'),
                'hidden'      => true,
                'static_link' => 'profession',
            ],
            // [
            //     'href'        => '/page?link=projects',
            //     'html'        => t('Проекты'),
            //     'static_link' => 'projects',
            //     'hidden'      => true,
            // ],
            // array(
            //     'href' => '/page?link=discount',
            //     'html' => t('Дисконт')
            // ),
            [
                'href'   => '/home?id=2',
                'html'   => t('Партнеры'),
                'hidden' => true,
            ],
            [
                'href'   => '/library',
                'html'   => t('Библиотека'),
                'hidden' => 'ru' === session::get('language') ? false : true,
            ],
            ['href' => '/page?link=contacts', 'html' => t('Контакты')],
        ];

        load::model('pages');
        $nodes           = db::get_cols('SELECT * FROM pages WHERE parent_id=0');
        $this->menu_tree = pages_peer::instance()->build_tree($nodes, true);
    }

    public function post_action()
    {
        parent::post_action();
    }
}
