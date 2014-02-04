<?

	abstract class Kohana_Iblock
	{

		public static function Add($fields)
		{
			$block = ORM::factory('Iblock');
			$list  = $block->table_columns();
			foreach ($fields as $key => $vol) {
				$block->set($key, $vol);
			}
			$block->save();
			return $list;
		}

		public static function del($id)
		{

		}

		public static function GetList()
		{

		}

		public static function GetProperties($iblock_id)
		{
			$block      = ORM::factory('Iblock', $iblock_id);
			$properties = $block->properties->find_all();
			return $properties;
		}

		public static function GetByID($id)
		{
			return ORM::factory('Iblock', $id);
		}

		public static function UpdateProperties($fields)
		{

			foreach ($fields as $key => $vol) {
				if (preg_match("|^[a-zA-Z_]+\_[0-9]+|", $key)) {
					preg_match_all("|^([a-zA-Z_]+)\_([0-9]+)|", $key, $encript);
					$keys[$encript[2][0]][$encript[1][0]] = $vol;
					$prop                                 = ORM::factory('Property', $encript[2][0]);
					$prop->set($encript[1][0], $vol);
					$prop->save();
				}
			}
			if (isset($keys) && count($keys) > 0) {
				foreach ($keys as $k => $v) {

					if (!key_exists('many', $v)) {
						$prop = ORM::factory('Property', $k);
						$prop->set('many', 0);
						$prop->save();
					}
					if (!key_exists('obyaz', $v)) {
						$prop = ORM::factory('Property', $k);
						$prop->set('obyaz', 0);
						$prop->save();
					}
				}
			}


		}

		public static function Update($fields, $id)
		{
			$iblock = ORM::factory('Iblock', $id);
			foreach ($fields as $k => $v) {
				$iblock->set($k, $v);
			}
			$iblock->save();
		}
	}
 