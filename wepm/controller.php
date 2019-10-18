<?php
/*
 * David Bray
 * BrayWorth Pty Ltd
 * e. david@brayworth.com.au
 *
 * This work is licensed under a Creative Commons Attribution 4.0 International Public License.
 * 		http://creativecommons.org/licenses/by/4.0/
 *
 * */

namespace dvc\wepm;
use strings;

class controller extends \Controller {
	protected function _index() {
		$seed = strtotime( '-7 days');
		$date = date('Y-m-d', $seed);

		$dao = new dao\wepm_event;
		$this->data = (object)[
			'title' => sprintf( 'WEPM Log : since %s', strings::asLocalDate( $date)),
			'dtoSet' => $dao->getUniqueSince( $date)

		];

		$this->render([
			'title' => $this->title = $this->label,
			'primary' => 'status',
			'secondary' =>'index'

		]);

	}

	protected function before() {
		config::wepm_checkdatabase();

		parent::before();

	}

	protected function getView( $viewName = 'index', $controller = null ) {
		$view = sprintf( '%s/views/%s.php', __DIR__, $viewName );		// php
		if ( file_exists( $view))
			return ( $view);

		return parent::getView( $viewName, $controller);

	}

	protected function posthandler() {
		$action = $this->getPost('action');

		if ( 'wemp-log' == $action) {
			$key = $this->getPost('key');
			if ( '-- some random password --' == $key) {
				$a = [
					'created' => \db::dbTimestamp(),
					'updated' => \db::dbTimestamp(),
					'event' => $this->getPost('event'),
					'locale' => $this->getPost('locale'),
					'active' => $this->getPost('active'),

				];

				$dao = new dao\wepm_event;
				$dao->Insert( $a);

			}

			\Json::ack( $action);

		}
		else { \Json::nak( $action); }

	}

	function __construct( $rootPath ) {
		$this->label = config::$WEBNAME;
		parent::__construct( $rootPath);

	}

}