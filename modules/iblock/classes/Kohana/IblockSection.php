<?

	class Kohana_IblockSection extends ORM
	{

		protected $_table_name = 'sections';

		/**
		 * @param null $fields
		 * @return array
		 */
		static public function GetList($fields = null)
		{
			$result = array();
			$res    = ORM::factory('Section');
			if (is_array($fields) && count($fields) == 1) {
				foreach ($fields as $key => $vol) {
					if (!is_array($vol)) {
						$res->where($key, "=", $vol);
					}
					else {
						$res->where($key, 'in', $vol);
					}
				}
			}
			elseif (is_array($fields) && count($fields) > 1) {
				//				$res->where_open();
				foreach ($fields as $key => $vol) {

					if (!is_array($vol)) {
						$res->and_where($key, "=", $vol);
					}
					else {
						$res->where($key, 'in', $vol);
					}
				}
				//				$res->where_close();
			}
			else {
				$res->where('section_id', '=', 0);
			}

			foreach ($res->find_all() as $value) {
				$result[] = $value;
				//				$result[] = $value->as_array();
			}
			return $result;
		}


		/**
		 * @param $id
		 * @return bool
		 */

		public static function GetByID($id)
		{
			$result = false;
			$obj    = ORM::factory('Section');
			$res    = $obj->where('id', ' = ', $id)
					->find();

			return $res;
		}

		public static function GetFile()
		{
			$t = ORM::factory('file')
					->find_all();
			return $t;
		}

		public static function Edit($fields, $id)
		{
			$obj = ORM::factory('Section',$id);
			foreach ($obj->table_columns() as $k => $v) {
				$columns[] = $k;
			}
			foreach ($fields as $key => $vol) {
				if (in_array($key, $columns)) {
					$obj->set($key, $vol);
				}
			};
			return $obj->save();
		}
	}
 