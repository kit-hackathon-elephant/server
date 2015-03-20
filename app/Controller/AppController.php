<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

  /**
	 * Aplication helper Property
	 * @var array helper name
	 */
	public $helpers = array('Html');

  /**
	 * success method
	 *
	 * @access private
	 * @return array status code and message.
	 */
	protected function success($obj, $code = '--', $message = '--') {

		$this->set_responce();

		// Generate response code and message
		$status = array(
			'code' => $code,
			'message' => $message,
			'condition' => "OK"
		);

		$returnObj = array(
			'status' => $status,
			'body' => $obj
		);

		$this->object_print($returnObj);
	}

  /**
	 * error method
	 *
	 * @access protected
	 * @return array status code and message.
	 */
	protected function error($code = '--', $message = '--') {

		$this->set_responce();

		// Generate response code and message
		$status = array(
			'status' => array(
				'code' => $code,
				'message' => $message,
				'condition' => "NG",
				'meta' => array(
					'url' => $this->request->here,
					'method' => $this->request->method(),
				)
			)
		);
		// If request is post
		if ($this->request->is('post')) {
			$status['status']['meta']['postData'] = $this->request->input();
		}

		$this->object_print($status);
	}

	/**
	¦* validationError method
	 *
	 *  @access protected
	 *  @return array status code and message.
	 */
	protected function validationError($code = '--', $message = '--', $modelName, $validationError = array()) {

		$this->set_responce();

		// Generate response code and message
		$status = array(
			'status' => array(
				'code' => $code,
				'message' => $message,
				'condition' => "NG",
				'validation' => array(
					$modelName => array()
				)
			)
		);
		//Set validationError message in $status
		foreach ($validationError as $key => $value) {
			$status['status']['validation'][$modelName][$key] = $value[0];
		}

		$this->object_print($status);
	}

  /**
	 * generate_token method
	 *
	 * return token
	 *
	 * @access protected
	 * @param integer $TOKEN_LENGTH token length
	 * @return string token
	 */
	protected function generate_token($LENGTH) {
		$token = openssl_random_pseudo_bytes($LENGTH);
		return bin2hex($token);
	}

	private function set_responce() {

		// set response view
		$this->autoRender = false;
		$this->response->type('application/json');
		$this->response->disableCache();

		return true;
	}

	private function object_print($object) {

		echo json_encode($object, JSON_FORCE_OBJECT);
	}

	protected function check_uuid($uuid) {
		if ($uuid == null) {
			throw new BadRequestException('Empty UUID');
		}

		return true;
	}
}
