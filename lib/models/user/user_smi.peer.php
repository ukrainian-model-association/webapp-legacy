<?php

class user_smi_peer extends db_peer_postgre
{
	protected $table_name = 'user_smi';

	/**
	 * {@inheritDoc}
	 */
	public static function instance($peer = 'user_smi_peer')
	{
		return parent::instance($peer);
	}
}
