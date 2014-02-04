<?php defined('SYSPATH') or die('No direct script access.');

	class Model_PropertyType extends ORM
	{
		protected $_table_name = 'property_type';
		protected $_has_many = array(
				'values' => array(
						'model' => 'Property',
						'foreign_key' => 'property_id'
				)
		);

	}