<?php

load::model('user/profile');
load::model('user/user_photos');
load::model('user/user_albums');

require_once 'Journal.php';

class journals_peer extends db_peer_postgre
{
    protected $table_name = 'journals';

    /**
     * @param string $peer
     *
     * @return journals_peer|db_peer|object
     */
    public static function instance($peer = 'journals_peer')
    {
        return parent::instance($peer);
    }

    public function get_item($primary_key)
    {
        if (!$item = parent::get_item($primary_key)) {
            return false;
        }

        $item['location'] = profile_peer::get_location($item);
        $item['contacts'] = unserialize($item['contacts']);
        $item['covers']   = user_photos_peer::instance()->get_list(['additional' => ['journal_id' => $item['id']]]);
        $item['fashion']  = user_albums_peer::instance()->get_list(['additional' => ['journal_id' => $item['id']]]);

        $item['models_count'] = 0;
        if (count($item['covers']) > 0) {
            $item['models_count'] = count(db::get_rows(sprintf('select user_id, count(id) from user_photos where id in (%s) group by user_id;', implode(', ', $item['covers']))));
        }

        return $item;
    }

    public function update($data, $keys = null)
    {
        if (isset($data['contacts']) && is_array($data['contacts'])) {
            $data['contacts'] = serialize($data['contacts']);
        }

        parent::update($data, $keys);
    }

    public function insert($data, $ignore_duplicate = false)
    {
        if (isset($data['contacts']) && is_array($data['contacts'])) {
            $data['contacts'] = serialize($data['contacts']);
        }

        return parent::insert($data, $ignore_duplicate);
    }

    public function get_item_country($primary_key)
    {
        $sql = sprintf('SELECT country FROM %s WHERE id = %s', $this->table_name, $primary_key);

        return db::get_scalar($sql);
    }

    public function findByCountry($country)
    {
        $sql = 'select * from journals where country = :country';

        return array_map(function ($context) {
            return $this->mapData($context);
        }, db::get_rows($sql, ['country' => $country]));
    }

    public function mapData($context)
    {
        $journal = new Journal();

        array_filter($context, static function ($value, $key) use ($journal) {
            $journal->{sprintf('set%s', str_replace('_', '', ucwords($key, '_')))}($value);
        }, ARRAY_FILTER_USE_BOTH);

        return $journal;
    }
}

