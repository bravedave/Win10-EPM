<?php
/*
 * David Bray
 * BrayWorth Pty Ltd
 * e. david@brayworth.com.au
 *
 * This work is licensed under a Creative Commons Attribution 4.0 International Public License.
 * 		http://creativecommons.org/licenses/by/4.0/
 *
*/

use dvc\wepm\config;

$dbc = 'sqlite' == \config::$DB_TYPE ?
	new \dvc\sqlite\dbCheck( $this->db, 'wepm_event' ) :
	new \dao\dbCheck( $this->db, 'wepm_event' );

$dbc->defineField( 'created', 'datetime');
$dbc->defineField( 'updated', 'datetime');
$dbc->defineField( 'event', 'varchar');
$dbc->defineField( 'locale', 'varchar');
$dbc->defineField( 'active', 'varchar');

$dbc->defineIndex('idx_wepm_event_created', 'created' );

$dbc->check();

