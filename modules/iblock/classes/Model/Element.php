<?php defined('SYSPATH') or die('No direct script access.');

	class Model_Element extends ORM
	{
		protected $_belongs_to = array(
				'section' => array(
						'Model' => 'Section',
						'foreign_key' => 'section_id',
				),

		);
		protected $_has_many = array(
				'property_value' => array(
						'Model' => 'PropertyValue',
//						'far_key' => '',
						'foreign_key' => 'element_id'
				),
		);

	}