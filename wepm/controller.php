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

use dvc\Request;

use Json;
use strings;
use sys;

class controller extends \Controller {

	protected function _index() {
		$seed = strtotime('-7 days');
		$date = date('Y-m-d', $seed);

		$dao = new dao\wepm_event;
		$this->data = (object)[
			'title' => sprintf('WEPM Log : since %s', strings::asLocalDate($date)),
			'dtoSet' => $dao->getUniqueSince($date)
		];

		$this->render([
			'meta' => [sprintf('<meta http-equiv="refresh" content="300; url=%s" />', strings::url($this->route))],
			'title' => $this->title = $this->label,
			'primary' => 'report',
			'secondary' => 'index'
		]);
	}

	protected function before() {

		config::wepm_checkdatabase();
		parent::before();
		$this->viewPath[] = __DIR__ . '/views/';
	}

	protected function posthandler() {

		$action = $this->getPost('action');

		if ('wemp-log' == $action) {
			/**
			 * curl -X POST -H "Accept: application/json" -d action=wemp-log -d key="-- some random password --" -d locale="COMPUTE-11" "http://localhost/"
			 */
			$key = $this->getPost('key');
			// REVIEW : Should get a password thing happening here
			if ('-- some random password --' == $key) {
				$a = [
					'created' => \db::dbTimestamp(),
					'updated' => \db::dbTimestamp(),
					'locale' => $this->getPost('locale'),
					'user' => $this->getPost('user'),
					'winver' => $this->getPost('winver'),
					'defender' => $this->getPost('defender'),
					'defenderService' => $this->getPost('defenderService'),
					'Antispyware' => $this->getPost('Antispyware'),
					'OnAccessProtection' => $this->getPost('OnAccessProtection'),
					'RealTimeProtection' => $this->getPost('RealTimeProtection'),
					'ControlledFolderAccess' => $this->getPost('ControlledFolderAccess'),
					'executionPolicy' => \json_encode([
						'UserPolicy' => $this->getPost('executionPolicy_UserPolicy'),
						'Process' => $this->getPost('executionPolicy_Process'),
						'CurrentUser' => $this->getPost('executionPolicy_CurrentUser'),
						'LocalMachine' => $this->getPost('executionPolicy_LocalMachine'),

					])

				];

				$dao = new dao\wepm_event;
				$dao->Insert($a);
			}

			Json::ack($action);
			return;	// because validation is disabled if this action is valid

		} elseif ('delete-endpoint' == $action) {
			if ($id = (int)$this->getPost('id')) {
				$dao = new dao\wepm_event;
				if ($dto = $dao->getByID($id)) {
					// sys::logger( sprintf('found %s : %s', $dto->locale, __METHOD__));
					$dao->Q(sprintf('DELETE FROM `wepm_event` WHERE `locale` = "%s"', $dao->escape($dto->locale)));
				}
				Json::ack($action);
			} else {
				Json::nak($action);
			}
		} else {
			parent::postHandler();
		}
	}

	function __construct($rootPath) {
		$this->label = config::$WEBNAME;

		/**
		 * have to use application wide Request
		 * - it is not initiated on controller yet
		 */
		if (Request::get()->isPost()) {
			$action = Request::get()->getPost('action');
			if ('wemp-log' == $action) {
				$this->RequireValidation = false;
				// sys::logger( sprintf('set RequireValidation false : %s', __METHOD__));

			}
		}

		parent::__construct($rootPath);
	}

	function view($id = 0) {
		if ($id = (int)$id) {
			$dao = new dao\wepm_event;
			if ($dto = $dao->getByID($id)) {
				$this->data = (object)[
					'dto' => $dto,

				];

				$this->render([
					'title' => $this->title = 'WEPM Event : view',
					'primary' => 'event-view',
					'secondary' => 'index'

				]);
			}
		}
	}
}
