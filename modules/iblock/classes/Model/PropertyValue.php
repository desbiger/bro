<?php defined('SYSPATH') or die('No direct script access.');

	class Model_PropertyValue extends ORM
	{
		protected $_table_name = 'property_values';
		protected $_belongs_to = array(
				'property' => array(
						'model' => 'Property',
						'foreign_key' => 'property_id'
				),
				'elements' => array(
						'model' => 'Element',
						'foreign_key' => 'element_id',
				),
		);

		static public function GetValue($el_id, $prop_id)
		{
			$res    = ORM::factory('PropertyValue')
					->where('element_id', "=", $el_id)
					->and_where('property_id', "=", $prop_id);
			$result = $res->find();
			return $result;
		}
	}