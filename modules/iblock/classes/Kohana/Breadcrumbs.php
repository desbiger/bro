<?

	class Kohana_Breadcrumbs
	{
		public static function GetPath($section_id,$block_id)
		{
			$path   = self::GetParent($section_id);
			$iblock = ORM::factory('Iblock',$block_id);
			$path[] = $iblock->as_array();
			return array_reverse($path);

		}

		static function GetParent($section_id, $res = array())
		{
			$res[] = ORM::factory('Section')
					->where('id', '=', $section_id)
					->find()
					->as_array();
			if (count($res) > 0) {
				if ($res[count($res) - 1]['section_id']) {
					$res = self::GetParent($res[count($res) - 1]['section_id'], $res);
				}
			}
			return $res;
		}
	}
 