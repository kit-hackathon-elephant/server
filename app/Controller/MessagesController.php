<?php
class MessagesController extends AppController {

	public $uses = array('Message','User');

	public function send($uuid = null) {
		try {

			// check and fetch from_user data
			$from_user = $this->fetch_user_data($uuid);

			if ($this->request->is('post')) {

				// fetch Post data
				$data['Message'] = json_decode($this->request->input(), true);
				$data['Message']['from_user_id'] = $from_user['User']['id'];

				// fetch to_user data
				$to_user = $this->fetch_user_data($data['Message']['to_user_id']);
				$data['Message']['to_user_id'] = $to_user['User']['id'];

				if ($this->Message->save($data)) {
					$this->success('Success','300', 'Message sended.');
				} else {
					$this->validationError('-301', 'Validation error', 'Message', $this->Message->validationErrors);
				}
			} else {
				throw new BadRequestException('POST Request Only');
			}

		} catch (Exception $e) {
			$this->error('-300', $e->getMessage());
		}
	}

	public function fetch($uuid = null) {
		try {

			// check and fetch user data
			$user = $this->fetch_user_data($uuid);

			// message from UserId
			$message = $this->Message->find(
				'all',
				array(
					'conditions' => array(
						'OR' => array(
							'to_user_id' => $user['User']['id'],
							'from_user_id' => $user['User']['id']
						)
					),
					'order' => array(
						'Message.created' => 'DESC'
					)
				)
			);

			$this->success($this->set_message_format($message), '310', 'fetch Message from UUID');

		} catch (Exception $e) {
			$this->error('-310', $e->getMessage());
		}
	}

	private function set_message_format($messages) {

		foreach($messages as $key => $message) {

			$messages[$key]['Message']['to_user_id'] = $message['ToUser']['uuid'];
			$messages[$key]['Message']['from_user_id'] = $message['FromUser']['uuid'];

			unset($messages[$key]['ToUser'],$messages[$key]['FromUser']);

		}

		return $messages;
	}

	private function fetch_user_data($uuid) {

		// Null check uuid
		$this->check_uuid($uuid);

		// fetch User Data
		if (($user = $this->User->findByUuid($uuid)) == null) {
			throw new BadRequestException('Not found User data');
		}

		return $user;
	}
}
