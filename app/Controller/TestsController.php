<?php
class TestsController extends AppController {

	public $uses = array();

	public function get() {

		// Accept GET request only
		if ($this->request->is('get')) {
			$this->success('Responce Object here!!', '1', 'Success');
		} else {

			// If the request method other than GET throw ErrorCode
			$this->error('-1', 'This method accept GET request only.');
		}
	}

	 public function post() {

		// Accept POST request only
		if ($this->request->is('post')) {
			$result["PostData"] = json_decode($this->request->input(),true);
			if ($result["PostData"] != null) {
				$this->success($result, '3', 'The post data has been acquisition.');
			} else {
				$this->error('-3', 'The post data not found.');
			}
		} else {

			// If the request method other than POST throw ErrorCode
			$this->error('-2', 'This method accept POST request only.');
		}
	}

	public function param($param0, $param1) {

		// Accept GET request only
		if ($this->request->is('get')) {

			// Genarate response data
			$result = array(
				'Param' => array(
					'param0' => $param0,
					'param1' => $param1
				)
			);
			$this->success($result, '4', 'The parameters has been acquisition');
		} else {

			// If the request method other than GETthrow ErrorCode
			$this->error('-4', 'This method accept GET request only');
		}
	}

}
