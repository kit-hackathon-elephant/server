<?php
class Profile extends AppModel {

	public $belongsTo = array('User','Sex','Type');

//	public $hasOne = array('Sex','Type');

	public $validate = array(
		'type_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => true,
				'message' => 'numeric only'
			)
		),
		'nickname' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'disapproval empty'
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'alphaNumeric only'
			)
		),
		'sex_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'disapproval empty'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'numeric only'
			)
		),
		'birthday' => array(
			'date' => array(
				'rule' => array('date','ymd'),
				'message' => 'date format : Ymd or Y-m-d and disapproval empty',
				'allowEmpty' => false
			)
		)
	);
}
