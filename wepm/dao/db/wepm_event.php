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
$dbc->defineField( 'locale', 'varchar');
$dbc->defineField( 'winver', 'varchar');
$dbc->defineField( 'user', 'varchar', 60);
$dbc->defineField( 'defender', 'varchar');
$dbc->defineField( 'defenderService', 'varchar');
$dbc->defineField( 'Antispyware', 'varchar');
$dbc->defineField( 'OnAccessProtection', 'varchar');
$dbc->defineField( 'RealTimeProtection', 'varchar');
$dbc->defineField( 'ControlledFolderAccess', 'varchar');
$dbc->defineField( 'executionPolicy', 'text');

$dbc->defineIndex('idx_wepm_event_created', 'created' );

$dbc->check();

