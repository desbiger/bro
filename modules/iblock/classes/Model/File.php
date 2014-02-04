<?

	class Model_File extends ORM
	{
		public function GetList()
		{

		}

		public function GetByID($id)
		{
			return $this->where('id', "=", $id)
					->find()
					->as_array();
		}

		public function UploadAndAdd($key, $file_name = null, $folder = null)
		{
            $ids = array();
			$file = ORM::factory('File');
			if ($_FILES[$key]['size'] > 0 && !is_array($_FILES[$key]['size'])) {
				$up = $_FILES[$key];
				$file->set('size', $up['size']);
				$file->set('type', $up['type']);
				$folder    = $folder == null ? 'upload/' : $folder;
				$full_path = Upload::save($up, $file_name, DOCROOT . $folder);
				$file->set('name', preg_replace("|.+/([^/]+[a-zA-Z]+)|", "$1", $full_path));

				return $file_id = $file->save();
			}
			elseif (is_array($_FILES[$key]['name'])) {
				foreach ($_FILES[$key]['name'] as $k => $files) {
					if ($files) {
						$up   = array(
								'name' => $files,
								'type' => $_FILES[$key]['type'][$k],
								'tmp_name' => $_FILES[$key]['tmp_name'][$k],
								'error' => $_FILES[$key]['error'][$k],
								'size' => $_FILES[$key]['size'][$k]
						);
						$file = ORM::factory('File');
						$file->set('size', $up['size']);
						$file->set('type', $up['type']);
						$folder    = $folder == null ? 'upload/' : $folder;
						$full_path = Upload::save($up, $file_name, DOCROOT . $folder);
						$file->set('name', preg_replace("|.+/([^/]+[a-zA-Z]+)|", "$1", $full_path));
						$ids[] = $file->save();
					}
				}
				return $ids;
			}
			else {
				return null;
			}
		}
	}
