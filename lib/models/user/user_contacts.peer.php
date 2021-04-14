<?php

class user_contacts_peer extends db_peer_postgre
{
    protected $table_name  = 'user_contacts';
    protected $primary_key = 'id';

    /**
     * @param string $peer
     *
     * @return user_contacts_peer|db_peer|object
     */
    public static function instance($peer = 'user_contacts_peer')
    {
        return parent::instance($peer);
    }
}