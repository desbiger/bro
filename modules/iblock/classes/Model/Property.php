<?php defined('SYSPATH') or die('No direct script access.');

	class Model_Property extends ORM
	{
		protected $_table_name = 'properties';
		protected $_has_many = array(
				'values' => array(
						'model' => 'PropertyValues',
						'foreign_key' => 'property_id'
				),
		);
		protected $_belongs_to = array(
				'PropertyType' => array(
						'model' => 'PropertyType',
						'foreign_key' => 'p_type'
				),
				'PropertyGroup' => array(
						'model' => 'PropertyGroup',
						'foreign_key' => 'group_id'
				)
		);

	}