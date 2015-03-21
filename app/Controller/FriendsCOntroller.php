<?php
class FriendsController extends AppController {

	public $uses = array('Friend','User','Profile');

	public function fetch($uuid = null) {
		try {
			$user = $this->fetch_user_data($uuid);

			$friend = $this->Friend->find(
				'list',
				array(
					'conditions' => array(
						'Friend.user_id' => $user['User']['id']
					),
					'fields' => array(
						'friend_id'
					)
				)
			);
			if ($friend == null ) {
				$profile = array(
					'Friend 0'
				);
			} else {
				$profile = $this->Profile->find(
					'all',
					array(
						'conditions' => array(
							'Profile.user_id' => $friend
						)
					)
				);
			}

			$this->success($profile, '600', 'send frend list');

		} catch (Exception $e) {
			$this->error('-600', $e->getMessage());
		}
	}

	private function fetch_user_data($uuid) {

		$this->check_uuid($uuid);

		if (($user = $this->User->findByUuid($uuid)) == null) {
			throw new BadRequestException('Not funcd User Data');
		}

		return $user;
	}
}
