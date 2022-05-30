<?php

class m220530_181137_create_app_tables extends CDbMigration
{
	public function safeUp()
 {
	$this->createTable('tbl_log', array(
		'id' => 'pk',
		'ip' => 'INT UNSIGNED NULL',
		'date' => 'datetime NOT NULL',
		'log' => 'text'
		), 'ENGINE=InnoDB'
	);
 }

 public function safeDown()
 {
 	$this->dropTable('tbl_log');
 }
}