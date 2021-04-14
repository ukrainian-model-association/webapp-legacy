<?php

class agency_user_peer extends db_peer_postgre
{
    protected $table_name = 'agency_user';

    public static function instance($peer = 'agency_user_peer')
    {
        return parent::instance($peer);
    }
}