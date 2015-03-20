<?php
class ProfilesController extends AppController {

	public $uses = array('Profile','Sex','Type','User');

	public function register($uuid = null) {
		try {
			$this->check_uuid($uuid);

			$user = $this->fetch_user_data($uuid);

			if ($this->request->is('get')) {

				// fetch sex and type lists
				$lists = $this->get_lists();
				$this->success($lists,'200','Return sex_list and type_list');

			} else if ($this->request->is('post')) {

				if ($this->Profile->findByUserId($user['User']['id']) != null) {
					throw new BadRequestException('Already registed Profile data');
				}

				// fetch post object
				$data['Profile'] = json_decode($this->request->input(),true);
				$data['Profile']['user_id'] = $user['User']['id'];

				// save profile data
				if ($this->Profile->save($data)) {
					$this->success($data, '201', 'Save Profile data');
				} else {
					$this->validationError('-201','Validate Error','Profile',$this->Profile->validationErrors);
				}
			} else {
				throw new BadRequestException('Your Request not approval (GET POST only)');
			}
		} catch (Exception $e) {
			$this->error('-200', $e->getMessage());
		}
	}

	public function detail($uuid = null) {
		try {

			// Check and fetch User data
			$this->check_uuid($uuid);
			$user = $this->fetch_user_data($uuid);

			// fetch Profile data
			if (($profile = $this->Profile->findByUserId($user['User']['id'])) != null) {
				$this->success($profile, '210', 'Return Profile data');
			} else {
				throw new BadRequestException('Please register Profile data');
			}
		} catch (Exception $e) {
			$this->error('-210', $e->getMessage());
		}
	}

	public function edit($uuid = null) {
		try {

			// Check and fetch User data
			$this->check_uuid($uuid);
			$user = $this->fetch_user_data($uuid);

			if ($this->request->is('get')) {

				// fetch Profile data
				if (($profile = $this->Profile->findByUserId($user['User']['id'])) != null) {
					$this->success($profile, '220', 'Return Profile data');
				} else {
					throw new BadRequestException('Please register Profile data');
				}

			} else if ($this->request->is(array('post','put'))) {

				// fetch post object
				$data['Profile'] = json_decode($this->request->input(),true);
				$data['Profile']['id'] = $user['Profile']['id'];
				$data['Profile']['user_id'] = $user['User']['id'];

				// save profile data
				if ($this->Profile->save($data)) {
					$this->success($data, '221', 'Save Profile data');
				} else {
					$this->validationError('-221','Validate Error','Profile',$this->Profile->validationErrors);
				}
			}

		} catch (Exception $e) {
			$this->error('-220', $e->getMessage());
		}
	}

	private function get_lists() {

		// fetch list from sex and type 
		$sex_list = $this->Sex->find('list');
		$type_list = $this->Type->find('list');

		return array(
			'sex' => $sex_list,
			'type' => $type_list
		);
	}

	private function fetch_user_data($uuid) {
		if (($user = $this->User->findByUuid($uuid)) == null) {
			throw new BadRequestException('Not found User data');
		}

		return $user;
	}
}
