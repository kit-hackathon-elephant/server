<?php
class Friend extends AppModel {
	public $belongsTo = array(
		'User',
		'FriendUser' => array(
			'className' => 'User',
			'foreignKey' => 'friend_id'
		)
	);

}
