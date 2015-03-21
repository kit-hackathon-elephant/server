<?php
class Message extends AppModel {
	public $belongsTo = array(
		'ToUser' => array(
			'className' => 'User',
			'foreignKey' => 'to_user_id'
		),
		'FromUser' => array(
			'className' => 'User',
			'foreignKey' => 'from_user_id'
		)
	);

	public $validate = array(
		'to_user_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'numeric only'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'disapproval empty'
			)
		),
		'from_user_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'numeric only'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'disapproval empty'
			)
		),
		'body' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'disapproval empty'
			)
		)
	);

}
