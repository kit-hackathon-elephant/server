<?php
class LocationsController extends AppController {


	public $uses = array('Location','User','Friend','Point');

	public function recode($uuid = null) {
		try {
			// null check and fetch User data
			$user = $this->fetch_user_data($uuid);

			if ($this->request->is('post')) {

				// fetch POST data
				$data['Location'] = json_decode($this->request->input(), true);
				$data['Location']['user_id'] = $user['User']['id'];

				// Location data save
				if ($this->Location->save($data)) {

					// fetch near user from geometry
					$this->fetch_near_user($data['Location'], $user['User']['id']);

					// set responce
					$this->success("Success", '400', 'Save location data');
				} else {

					// validation error
					$this->validationError('-401', 'Validation error', 'Location', $this->Location->validationErrors);

				}

			} else {
				throw new BadRequestException('aproval POST request only');
			}
		} catch (Exception $e) {
			$this->error('-400', $e->getMessage());
		}
	}

	private function fetch_near_user($geometry, $user_id) {

		// fetch near user 10m
		$near_user = $this->Location->find(
			'all',
			array(
				'conditions' => array(
					'AND' => array(
						'Location.longitude BETWEEN ? AND ?' => array(
							($geometry['longitude'] - 0.000001),
							($geometry['longitude'] + 0.000001)
						),
						'Location.latitude BETWEEN ? AND ?' => array(
							($geometry['latitude'] - 0.0001),
							($geometry['latitude'] + 0.0001)
						),
						'Location.created >' => date("Y-m-d H:i:s",strtotime("-1 minute")),
					),
					'NOT' => array(
						'Location.user_id' => $user_id
					)
				)
			)
		);

		if ($near_user != null) {
			foreach($near_user as $near_user_data) {
				$this->save_near_user($user_id, $near_user_data['Location']['user_id']);
				$this->save_near_user($near_user_data['Location']['user_id'], $user_id);
			}
		}

		return true;
	}

	private function save_near_user($user_id,$near_user_id) {

		// generate friend data
		$friend_data = array(
			'user_id' => $user_id,
			'friend_id' => $near_user_id
		);

		// fetch friend user
		$already_friend_user = $this->Friend->find(
			'first',
			array(
				'conditions' => array(
					'AND' => $friend_data
				)
			)
		);

		if ($already_friend_user == null) {

			// if save faild
			$this->Friend->create();
			if (!$this->Friend->save($friend_data)) {
				throw new BadRequestException('Near user data save faild');
			}

			$this->update_point($user_id);

		}

		return true;
	}

	private function update_point($user_id) {

		if (($point_data = $this->Point->findByUserId($user_id)) == null) {

			$this->Point->create();
			$save_data = array(
				'id' => false,
				'user_id' => $user_id,
				'value' => 1
			);
		} else {
			$save_data = array(
				'id' => $point_data['Point']['id'],
				'value' => ($point_data['Point']['value'] + 1)
			);
		}

		// save point
		if (!$this->Point->save($save_data)) {
			throw new BadRequestException('Point save faild');
		}

		return true;
	}

	private function fetch_user_data($uuid) {

		// null check
		$this->check_uuid($uuid);

		// fetch User
		if (($user = $this->User->findByUuid($uuid)) == null) {
			throw new BadRequestException('Not found User');
		}

		return $user;

	}
}
