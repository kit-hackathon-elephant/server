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

		// set response view
		$this->autoRender = false;
		$this->response->type('application/json');

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

		echo json_encode($returnObj, JSON_FORCE_OBJECT);
	}

  /**
	 * error method
	 *
	 * @access protected
	 * @return array status code and message.
	 */
	protected function error($code = '--', $message = '--') {

		// set response view
		$this->autoRender = false;
		$this->response->type('application/json');

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
		echo json_encode($status, JSON_FORCE_OBJECT);
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
}
