<?php

class PointsController extends AppController {

	public $uses = array('Point','User');

	public function info($uuid = null) {
		try {
			$user = $this->fetch_user_data($uuid);

			if (($point = $this->Point->findByUserId($user['User']['id'])) == null) {

				// genarate 0 point data
				$point['Point'] = array(
					'user_id' => $user['User']['id'],
					'value' => 0
				);

				// save point data
				if (!$this->Point->save($point)) {
					throw new BadRequestException('');
				}
			}

			$this->success($point, '500', 'Return Point');


		} catch (Exception $e) {
			$this->error('-500', $e->getMessage());
		}
	}

	private function fetch_user_data($uuid) {
		$this->check_uuid($uuid);

		if (($user = $this->User->findByUuid($uuid)) == null) {
			throw new BadRequestException('Not found User data');
		}

		return $user;

	}
}
