<?php defined('SYSPATH') or die('No direct script access.');

	class Model_Iblock extends ORM
	{
		protected $_table_name = "blocks";
		protected $_has_many = array(
				'properties' => array(
						'model' => 'Property',
						'foreign_key' => 'block_id',
				)
		);

	}