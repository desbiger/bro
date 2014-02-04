<?php defined('SYSPATH') or die('No direct script access.');

	class Model_Section extends ORM
	{
		protected $_has_many = array(
				'sections' => array(
						'model' => 'section',
						'foreign_key' => 'section_id'
				),
				'elements' => array(
						'model' => 'element',
						'far_key' => 'section_id'
				)
		);

		static function array_merge($ar1, $ar2)
		{
			foreach ($ar2 as $k => $v) {
				$ar1[$k] = $v;
			}
			return $ar1;
		}

		static public function GetListForSelect($iblock_id, $section_id = 0, $depth_level = -1)
		{
			$result[] = '';
			if ($section_id or $section_id == 0) {
				$sections = ORM::factory('Section')
						->where('block_id', '=', $iblock_id)
						->and_where('section_id', '=', $section_id)
						->find_all();
				$depth_level++;
				foreach ($sections as $s) {

					$result[$s->id] = str_repeat('.', $depth_level) . $s->name;
					if (count($sub = self::GetListForSelect($iblock_id, $s->id, $depth_level)) > 0) {
						$result = self::array_merge($result, $sub);
					}
				}
			}
			return $result;

		}

		static function GetSectionForSelect($block_id, $section_id, $depth_level)
		{

		}
	}