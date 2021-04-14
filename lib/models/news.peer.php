<?php

use App\Entity\Post;

load::model('user/profile');

class news_peer extends db_peer_postgre
{
    const HREF_FILTERED_BY_TYPE = '/news?type=%d';

    const NEWS_TYPE          = 1;
    const PUBLICATIONS_TYPE  = 2;
    const ANNOUNCEMENTS_TYPE = 3;

    const TYPES_MAP = [
        self::NEWS_TYPE          => 'Новости',
        self::PUBLICATIONS_TYPE  => 'Публикации',
        self::ANNOUNCEMENTS_TYPE => 'Анонсы',
    ];

    public $html = '';

    protected $table_name = 'news';

    public static function get_types($id = null)
    {
        $ret = [
            self::NEWS_TYPE          => t('Новости'),
            self::PUBLICATIONS_TYPE  => t('Публикации'),
            self::ANNOUNCEMENTS_TYPE => t('Анонсы'),
        ];

        if (null === $id) {
            return $ret;
        }

        return isset($ret[$id]) ? $ret[$id] : false;
    }

    public static function getFilteredByTypeHref($type)
    {
        return sprintf(self::HREF_FILTERED_BY_TYPE, $type);
    }

    public function get_content($id)
    {
        $data = self::instance()->get_item($id);
        if ($data) {
            $tmp            = unserialize($data['title']);
            $data['title']  = stripslashes($tmp[session::get('language', 'ru')]);
            $tmp            = unserialize($data['body']);
            $data['body']   = stripslashes($tmp[session::get('language', 'ru')]);
            $tmp            = unserialize($data['anons']);
            $data['anons']  = stripslashes($tmp[session::get('language', 'ru')]);
            $data['models'] = unserialize($data['models']);

            return $data;
        }

        return false;
    }

    /**
     * @param string $peer
     *
     * @return db_peer|news_peer
     */
    public static function instance($peer = 'news_peer')
    {
        return parent::instance($peer);
    }

    public function resolveList()
    {

    }
}
