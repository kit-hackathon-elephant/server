<?php
class AddMessageTableAndFixColums extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_message_table_and_fix_colums';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'messages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
					'to_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'from_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
			'create_field' => array(
				'profiles' => array(
					'color' => array('type' => 'string', 'null' => false, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'user_id'),
					'twitter' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'color'),
					'facebook' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'twitter'),
					'crated' => array('type' => 'datetime', 'null' => false, 'default' => null, 'after' => 'facebook'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'after' => 'crated'),
				),
			),
			'drop_field' => array(
				'profiles' => array('image_flag'),
			),
			'alter_field' => array(
				'profiles' => array(
					'nickname' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
				'sexes' => array(
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
				'types' => array(
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
				'users' => array(
					'uuid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'messages'
			),
			'drop_field' => array(
				'profiles' => array('color', 'twitter', 'facebook', 'crated', 'modified'),
			),
			'create_field' => array(
				'profiles' => array(
					'image_flag' => array('type' => 'boolean', 'null' => false, 'default' => null),
				),
			),
			'alter_field' => array(
				'profiles' => array(
					'nickname' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
				'sexes' => array(
					'name' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
				'types' => array(
					'name' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
				'users' => array(
					'uuid' => array('type' => 'string', 'null' => false, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
				),
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
