<?php
class AddGeometoryTableAndColumOptionChange extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_geometory_table_and_colum_option_change';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'friends' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'friend_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'locations' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
					'longitude' => array('type' => 'double', 'null' => false, 'default' => null, 'unsigned' => false),
					'latitude' => array('type' => 'double', 'null' => false, 'default' => null, 'unsigned' => false),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'points' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
					'value' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'user_id' => array('column' => 'user_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
			'alter_field' => array(
				'profiles' => array(
					'type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 3, 'unsigned' => false),
					'color' => array('type' => 'string', 'null' => true, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
				'users' => array(
					'uuid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
			),
			'create_field' => array(
				'users' => array(
					'indexes' => array(
						'uuid' => array('column' => 'uuid', 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'friends', 'locations', 'points'
			),
			'alter_field' => array(
				'profiles' => array(
					'type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => false),
					'color' => array('type' => 'string', 'null' => false, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
				'users' => array(
					'uuid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
			),
			'drop_field' => array(
				'users' => array('indexes' => array('uuid')),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
