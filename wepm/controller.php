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
					'locale' => $this->getPost('locale'),
					'defender' => $this->getPost('defender'),
					'defenderService' => $this->getPost('defenderService'),
					'Antispyware' => $this->getPost('Antispyware'),
					'OnAccessProtection' => $this->getPost('OnAccessProtection'),
					'RealTimeProtection' => $this->getPost('RealTimeProtection'),
					'executionPolicy' => \json_encode([
						'UserPolicy' => $this->getPost('executionPolicy_UserPolicy'),
						'Process' => $this->getPost('executionPolicy_Process'),
						'CurrentUser' => $this->getPost('executionPolicy_CurrentUser'),
						'LocalMachine' => $this->getPost('executionPolicy_LocalMachine'),

					])

				];

				$dao = new dao\wepm_event;
				$dao->Insert( $a);

			}

			\Json::ack( $action);
			return;	// because validation is disabled if this action is valid

		}
		else { \Json::nak( $action); }

	}

	function __construct( $rootPath ) {
		$this->label = config::$WEBNAME;
		if ( $this->isPost()) {
			$action = $this->getPost('action');
			if ( 'wemp-log' == $action) {
				$this->RequireValidation = false;

			}

		}

		parent::__construct( $rootPath);

	}

	function view( $id = 0) {
		if ( $id = (int)$id ) {
			$dao = new dao\wepm_event;
			if ( $dto = $dao->getByID( $id)) {
				$this->data = (object)[
					'dto' => $dto,

				];

				$this->render([
					'title' => $this->title = 'WEPM Event : view',
					'primary' => 'event-view',
					'secondary' =>'index'

				]);

			}

		}

	}

}