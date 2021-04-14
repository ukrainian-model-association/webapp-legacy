<?php

load::app('modules/home/controller');
load::model('user/user_albums');
load::model('user/profile');

/**
 * @property array json
 */
class home_index_action extends home_controller
{
    public function execute()
    {
        $act = request::get_string('act');
        if ('get_next_update' === $act) {
            $this->set_renderer('ajax');

            return $this->json['success'] = $this->$act();
        }

        // MAIN PAGE NEWS
        load::model('news');
        if ($news_id = db::get_scalar(
            'SELECT id FROM news WHERE type=:type AND hidden=0 ORDER BY created_ts DESC LIMIT 1',
            ['type' => news_peer::NEWS_TYPE]
        )
        ) {
            $this->news = news_peer::instance()->get_content($news_id);
        }
        if ($publication_id = db::get_scalar(
            'SELECT id FROM news WHERE type=:type AND hidden=0 ORDER BY created_ts DESC LIMIT 1',
            ['type' => news_peer::PUBLICATIONS_TYPE]
        )
        ) {
            $this->publication = news_peer::instance()
                ->get_content($publication_id);
        }

        $anons_id = db::get_scalar('SELECT id FROM news WHERE type=:type AND hidden=0 AND end_ts>:date ORDER BY created_ts ASC LIMIT 1', [
            'type' => news_peer::ANNOUNCEMENTS_TYPE,
            'date' => time(),
        ]); ////////////Ближайшее событие
        if (!$anons_id) {
            $anons_id = db::get_scalar(
                'SELECT id FROM news WHERE type=:type AND end_ts<=:date AND hidden=0 ORDER BY created_ts DESC LIMIT 1',
                [
                    'type' => news_peer::ANNOUNCEMENTS_TYPE,
                    'date' => time(),
                ]
            );
        } ////////////Последнее событие
        if ($anons_id) {
            $this->anons = news_peer::instance()->get_content($anons_id);
        }

        //              MOST POPULAR
        load::model('voting');
        $list             = voting_peer::getModelsVoteList();
        $checkList        = voting_peer::getModelsVoteList(session::get_user_id());
        $this->check_vote = count($checkList) > 1;
        $rand             = $this->get_random_data($list, 2);
        $this->model1     = $rand[0];
        $this->model2     = $rand[1];

        // MOST SUCCESSFULL
        $this->successfulModels   = $this->getGirls('successful_model');
        $this->associationMembers = $this->getGirls('member_of_association');


        // NEW FACES
        // $this->new_faces = $this->getGirls(1);
        //
        // PERSPECTIVE
        // $this->perspective = $this->getGirls(2);
        //
        // legendary
        // $this->legendary = $this->getGirls(3);

        $updates = db::get_rows("SELECT id, category FROM user_albums WHERE category IN ('covers', 'fashion', 'defile', 'advertisement', 'catalogs') AND images <> 'a:0:{}' AND user_id IN (SELECT id FROM user_auth WHERE hidden = false AND type = 2) ORDER BY modified DESC");

        $boxes = [
            [
                'category' => 'covers',
                'updates'  => [],
                'images'   => [],
            ],
            [
                'category' => 'fashion',
                'updates'  => [],
                'images'   => [],
            ],
            [
                'category' => 'defile',
                'updates'  => [],
                'images'   => [],
            ],
            [
                'category' => 'adv',
                'updates'  => [],
                'images'   => [],
            ],
        ];

        $this->users = [];

        foreach ($updates as $update) {
            $index = 0;

            if ('fashion' === $update['category']) {
                $index = 1;
            } else if ('defile' === $update['category']) {
                $index = 2;
            } else if (in_array($update['category'], ['advertisement', 'catalogs'])) {
                $index = 3;
            } else if ('covers' !== $update['category']) {
                continue;
            }

            $album = user_albums_peer::instance()->get_item($update['id']);

            $boxes[$index]['images'] = array_merge($boxes[$index]['images'], $album['_i']);

            foreach ($album['_i'] as $pid) {
                $this->users[$pid] = $album['user_id'];
            }

            $boxes[$index]['updates'][] = $album;
        }

        $this->boxes = $boxes;
    }

    private function get_random_data($data, $elements_count)
    {
        if ($elements_count > 0 && count($data) >= $elements_count) {
            for ($i = 0; $i < $elements_count; ++$i) {
                $rand  = rand(0, (count($data) - 1));
                $ret[] = $data[$rand];
                unset($data[$rand]);
                sort($data);
            }

            return $ret;
        }

        return $data;
    }

    /**
     * @param string|null $target
     *
     * @return array|mixed
     */
    private function getGirls($target = null)
    {
        $sql = '
select ua.id,
       ud.pid,
       ud.ph_crop,
       ud.first_name,
       ud.last_name
from user_auth ua
         join user_data ud on ua.id = ud.user_id
where ua.del = 0
  and ud.pid is not null
  and ud.ph_crop is not null
  and ua.hidden = false
  %s
limit 24
';

        switch (true) {
            case 'successful_model' === $target:
                return db::get_rows(sprintf($sql, 'and ua.successful_model = true order by ud.rank'));

            case 'member_of_association' === $target:
                return db::get_rows(sprintf($sql, 'and ua.member_of_association = true order by ud.rank'));

            default:
                return [];
        }
    }

    public function get_next_update()
    {
        $category = request::get_string('category');
        $step     = request::get_int('step');

        $updates = db::get_rows(
            "SELECT id, category FROM user_albums WHERE category = :category AND images <> 'a:0:{}' AND user_id IN (SELECT id FROM user_auth WHERE hidden = false AND type = 2) ORDER BY modified DESC",
            ['category' => $category]
        );

        $images = [];
        $users  = [];

        foreach ($updates as $update) {
            $album = user_albums_peer::instance()->get_item($update['id']);

            $images = array_merge($images, $album['_i']);

            foreach ($album['_i'] as $pid) {
                $users[$pid] = $album['user_id'];
            }
        }

        rsort($images);

        $this->json['image'] = $images[$step];

        $profile                 = profile_peer::instance()
            ->get_item($users[$this->json['image']]);
        $this->json['user_name'] = '<a class="cwhite" href="/profile?id='
            . $users[$this->json['image']] . '">'
            . profile_peer::get_name($profile, '&fn') . ' <span class="ucase">'
            . profile_peer::get_name(
                $profile,
                '&ln'
            ) . '</span></a>';

        return true;
    }
}
