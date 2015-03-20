<?php
class UsersController extends AppController {

	public function signup(){
		try {

			// generate token
			$user['uuid'] = $this->generate_token(32);

			// save genarated token
			if ($this->User->save($user)) {
				$this->success($user,'10','Generate UUID');
			} else {
				$this->validationError('-11','Validate Error','User',$this->User->validationErrors);
			}
		} catch (Exception $e) {

			$this->error('-10', $e->getMessage());
		}
	}

	public function info($uuid = null) {
		try {
			if ($uuid == null) {
				throw new BadRequestException('Undefined UUID');
			}

			if ($this->request->is('get')) {

				// fetch User data
				if (($user = $this->User->findByUuid($uuid)) != null) {
					$this->success($user, '11', 'Success find User info from uuid');
				} else {
					throw new BadRequestException('Not found User data');
				}
			} else {
				throw new BadRequestException('approval GET request only');
			}
		} catch (Exception $e) {
			$this->error('-10',$e->getMessage());
		}
	}
}
