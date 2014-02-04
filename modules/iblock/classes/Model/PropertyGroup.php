<?php defined('SYSPATH') or die('No direct script access.');

	class Model_PropertyGroup extends ORM
	{
		protected $_table_name = 'property_groups';
		protected $_has_many = array(
				'properties' => array(
						'model' => 'Property',
						'foreign_key' => 'group_id'
				)
		);


		static public function GetListAll($block_id)
		{
			$arResult = array();
			$groups = ORM::factory('PropertyGroup')
					->where('block_id', "=", $block_id)
					->find_all();
			foreach ($groups as $vol) {
				$props    = '';
				$elements = $vol->properties->find_all();
				foreach ($elements as $el) {
					$props[] = $el->as_array();
				}
				$arResult[$vol->name] = array(
						$vol->as_array(),
						$props
				);
			}
			return $arResult;
		}
	}