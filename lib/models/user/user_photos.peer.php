<?php

class user_photos_peer extends db_peer_postgre
{
    const TYPE_CARD         = 1;
    const TYPE_CARD_PREVIEW = 2;
    protected $table_name  = 'user_photos';
    protected $primary_key = 'id';

    /**
     * @param string $peer
     *
     * @return user_photos_peer|db_peer|object
     */
    public static function instance($peer = 'user_photos_peer')
    {
        return parent::instance($peer);
    }

    public function get_item($primary_key)
    {
        $item = parent::get_item($primary_key);

        $item['_a'] = unserialize($item['additional']);
        if (!is_array($item['_a'])) {
            $item['_a'] = [];
        }

        return $item;
    }

    public function get_list($where = [], $bind = [], $order = [], $limit = '', $cache_key = null)
    {
        $add_array = null;
        if (isset($where['additional'])) {
            $add_array = [];

            $list = db::get_rows(sprintf('SELECT id, additional FROM %s WHERE additional IS NOT NULL', $this->table_name));

            foreach ($list as $item) {
                $item['additional'] = unserialize($item['additional']);

                if (!is_array($item['additional'])) {
                    continue;
                }

                foreach ($where['additional'] as $key => $value) {
                    if (isset($item['additional'][$key]) && $item['additional'][$key] == $value) {
                        $add_array[] = $item['id'];
                    }
                }
            }

            unset($where['additional']);
        }

        if (is_array($add_array)) {
            return array_values(array_intersect(parent::get_list($where, $bind, $order, $limit, $cache_key), $add_array));
        }

        return parent::get_list($where, $bind, $order, $limit, $cache_key);
    }
}
