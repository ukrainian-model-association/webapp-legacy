<?php

/**
 * This file is part of the modelsua/modelsua package.
 */

load::view_helper('ui', false);

load::model('date');

class user_foreign_works extends db_peer_postgre
{
    protected $table_name  = 'user_foreign_works';
    protected $primary_key = 'id';

    public static function instance($peer = 'user_foreign_works')
    {
        return parent::instance($peer);
    }

    public function get_item($primary_key)
    {
        $item = parent::get_item($primary_key);

        $from = DateTime::createFromFormat('Y-m-d H:i:s', $item['from_ts']);
        $to   = DateTime::createFromFormat('Y-m-d H:i:s', $item['to_ts']);

        if ($from && $to) {
            $item['from_month'] = date_peer::instance()->get_month((int) $from->format('m'));
            $item['to_month']   = date_peer::instance()->get_month((int) $to->format('m'));
            $item['from_year']  = $from->format('Y');
            $item['to_year']    = $to->format('Y');
        } else {
            $item['from_month'] = '-';
            $item['from_year']  = '-';
            $item['to_month']   = '-';
            $item['to_year']    = '-';
        }

        return $item;
    }
}
