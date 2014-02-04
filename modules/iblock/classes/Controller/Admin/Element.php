<?php defined('SYSPATH') or die('No direct script access.');

	class Controller_Admin_Element extends Controller_Admin_Base
	{
		public function before()
		{
			parent::before();
			$id                      = $this->request->param('id');
			$this->template->content = View::factory("admin/elements_detail_table");

			$this->sections = ORM::factory('Section')
					->GetListForSelect($this->request->param('iblock_id'));
			//			echo "<pre>".print_r($this->sections,true)."</pre>";
		}

		public function action_index()
		{

		}

		public function action_edit()
		{

			$id                    = $this->request->param('section_id') ? $this->request->param('section_id') : 0;
			$block_id              = $this->request->param('iblock_id');
			$items                 = Breadcrumbs::GetPath($id, $this->request->param('iblock_id'));
			$this->template->title = "Редактирование элемента";


			if (isset($_REQUEST['sub']) == 'Сохранить') {
				$element = ORM::factory('Element', $this->request->param('id'));
				foreach ($this->request->post() as $key => $vol) {
					if ($key != 'sub' && !preg_match("|prop_.*|", $key)) {
						$element->set($key, $vol);
					}
					elseif (preg_match("|prop_.*|", $key) && $vol != '') {
						$explode = explode("_", $key);
						file_put_contents(DOCROOT . "/explode.php", print_r($explode, true));
						$el_id   = $explode[1];
						$prop_id = $explode[2];

						IblockElementProperty::UpdateProperty($el_id, $prop_id, $vol);
					}
				}
				$file = ORM::factory('File');

//				echo "<pre>" . print_r($_FILES['prop_1_1'], true) . "</pre>";
//				die;



				foreach ($_FILES as $k => $v) {

					if (preg_match("|prop_[0-9]+_[0-9]+|", $k) && is_array($_FILES[$k]['name'])) {

						echo "<pre>" . print_r($_FILES[$k], true) . "</pre>";
//						die;
						$explode      = explode("_", $k);
						$el_id        = $explode[1];
						$prop_id      = $explode[2];
						$prop_type_id = ORM::factory('Property', $prop_id)->p_type;
						$prop_type    = IblockElementProperty::GetPropertyTypeByID($prop_type_id);
						if ($prop_type->id == 6) {

							if ($img = $file->UploadAndAdd($k)) {
								if (!is_array($img)) {
									IblockElementProperty::UpdateProperty($el_id, $prop_id, $img);
								}
								else {
									foreach ($img as $i) {
										IblockElementProperty::UpdateProperty($el_id, $prop_id, $i);
									}
								}
							};
						}

					}
					elseif (!preg_match("|prop_.*|", $k) && $file_id = $file->UploadAndAdd($k)) {
						$element->set($k, $file_id);
					};
				}
				$element->update();
				$this->redirect("/admin/info/" . $this->request->param('iblock_id') . "/main/index/{$id}");
			}


			$id              = $this->request->param('id');
			$section_id      = $this->request->param('section_id');
			$element         = ORM::factory('Element', $id);
			$preview_picture = ORM::factory('File', $element->preview_picture)
					->as_array();
			if ($preview_picture['size'] > 0) {
				Image::factory(DOCROOT . "upload/" . $preview_picture['name'])
						->resize('100', '100')
						->save(DOCROOT . 'upload/preview/' . $preview_picture['name']);
			}
			$detail_picture = ORM::factory('File', $element->detail_picture)
					->as_array();
			if ($detail_picture['size'] > 0) {
				Image::factory(DOCROOT . "upload/" . $detail_picture['name'])
						->resize('100', '100')
						->save(DOCROOT . 'upload/preview/' . $detail_picture['name']);
			}

			$props = ORM::factory('PropertyGroup')
					->GetListAll($this->request->param('iblock_id'));

			$this->template->content = View::factory("admin/elements_detail_table")
					->bind('element', $element)
					->bind('sections', $this->sections)
					->bind('section', $section_id)
					->bind('props', $props)
					->bind('block_id', $block_id)
					->bind('pre_picture', $preview_picture)
					->bind('items', $items)
					->bind('det_picture', $detail_picture);
		}

		public function action_add()
		{
			$props    = ORM::factory('PropertyGroup')
					->GetListAll($this->request->param('iblock_id'));
			$block_id = $this->request->param('iblock_id');


			if (isset($_REQUEST['sub']) == 'Сохранить') {
				$element = ORM::factory('Element');
				foreach ($_POST as $key => $vol) {
					if ($key != 'sub' && !preg_match("|prop_.*|", $key)) {
						$element->set($key, $vol);
					}
				}
				//				if ($this->request->param('id')) {
				//					$element->set('section_id', $this->request->param('id'));
				//				}
				//				else {
				//					$element->set('section_id', 0);
				//				}
				$file = ORM::factory('File');
				foreach ($_FILES as $k => $v) {
					if ($v['size'] > 0) {

						$file->set('size', $v['size']);
						$file->set('type', $v['type']);
						$full_path = Upload::save($v, null, DOCROOT . 'upload/');
						$file->set('name', preg_replace("|.+/([^/]+[a-zA-Z]+)|", "$1", $full_path));

						$file_id = $file->save();
						$element->set($k, $file_id);
					}
				}
				$element->set('block_id', $this->request->param('iblock_id'));
				$element->save();
				$this->redirect("/admin/info/" . $this->request->param('iblock_id') . "/main/index/" . $this->request->param('id'));
			}
			else {
				$prop_types  = ORM::factory('PropertyType')
						->find_all();
				$iblock_id   = $this->request->param('iblock_id');
				$prop_groups = ORM::factory('PropertyGroup')
						->where('block_id', '=', $iblock_id)
						->find_all();
				$gr          = array();
				foreach ($prop_groups as $group) {
					$props_list = ORM::factory('Property')
							->where('group_id', '=', $group->id)
							->find_all();
					$properties = array();
					foreach ($props_list as $property) {
						$properties[] = $property->as_array();
					}
					$gr[$group->name] = $properties;
				}
				foreach ($prop_types as $vol) {
					$types[$vol->id] = $vol->name;
				}


				$section_id              = $this->request->param('section_id') ? $this->request->param('section_id') : '';
				$items                   = Breadcrumbs::GetPath($section_id, $this->request->param('iblock_id'));
				$section                 = $this->request->param('id');
				$this->template->content = View::factory('admin/v_form_element_add')
						->bind('props', $props)
						->bind('sections', $this->sections)
						->bind('section', $section)
						->bind('section_id', $section_id)
						->bind('block_id', $block_id)
						->bind('items', $items);
			}

		}
	}