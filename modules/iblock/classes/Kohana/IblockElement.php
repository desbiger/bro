<?

	class Kohana_IblockElement extends ORM
	{


		/**
		 * @param null $fields
		 * @return array
		 */
		static public function GetList($fields = null)
		{
			$result = array();
			$res    = ORM::factory('Element');
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
			}elseif($fields == 0){
				$res->where('section_id',"=",0);
			}

			return $res->find_all();
		}


		/**
		 * @param $id
		 * @return array
		 */
		static public function GetByID($id)
		{
			$obj  = ORM::factory('element');
			$find = $obj->where('id', "=", $id)
					->find()
					->as_array();
			return $find;
		}

		static public function AddElement($fields)
		{

		}

		static public function DeleteElement($id)
		{

		}

		static function UpdateElement($fields)
		{

		}
	}
 