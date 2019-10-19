<?php
/*
	David Bray
	BrayWorth Pty Ltd
	e. david@brayworth.com.au

	This work is licensed under a Creative Commons Attribution 4.0 International Public License.
		http://creativecommons.org/licenses/by/4.0/

	*/
namespace dvc\wepm;

abstract class config extends \config {
	static $WEBNAME = 'Windows 10 End Point Monitor for DVC';

	const wepm_db_version = 0.06;

	static protected $_WEPM_VERSION = 0;

	static function wepm_checkdatabase() {
		if ( self::wepm_version() < self::wepm_db_version) {
			config::wepm_version( self::wepm_db_version);

			$dao = new dao\dbinfo;
			$dao->dump( $verbose = false);

		}

		// sys::logger( 'bro!');

	}

	static function wepm_config() {
		return sprintf( '%s%swepm.json', self::dataPath(), DIRECTORY_SEPARATOR);

	}

	static function wepm_init() {
		if ( file_exists( $config = self::wepm_config())) {
			$j = json_decode( file_get_contents( $config));

			if ( isset( $j->wepm_version)) {
				self::$_WEPM_VERSION = (float)$j->wepm_version;

			};

		}

	}

	static protected function wepm_version( $set = null) {
		$ret = self::$_WEPM_VERSION;

		if ( (float)$set) {
			$config = self::wepm_config();

			$j = file_exists( $config) ?
				json_decode( file_get_contents( $config)):
				(object)[];

			self::$_WEPM_VERSION = $j->wepm_version = $set;

			file_put_contents( $config, json_encode( $j, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

		}

		return $ret;

	}

}

config::wepm_init();
