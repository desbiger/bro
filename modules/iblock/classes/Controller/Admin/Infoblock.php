<?php defined('SYSPATH') or die('No direct script access.');

	class Controller_Admin_Infoblock extends Controller_Admin_Base
	{
		public $template = "admin/main";

		public function before()
		{
			parent::before();
			$this->template->title    = "BRO-CMS";
			$this->template->left_row = View::factory('admin/left_menu');
			$elements                 = ORM::factory('Iblock')
					->find_all();
			$cur                      = '';

			$this->template->content = View::factory('admin/infoblocks_table')
					->bind('cur', $cur)
					->bind('elements', $elements);
		}

		public function action_index()
		{

		}

		public function action_add()
		{
			$id     = $this->request->param('id');
			$breads = Breadcrumbs::GetPath((bool)$id ? $id : 0, $this->request->param('iblock'));

			if ($this->request->post('sub') == 'Сохранить') {
				$list = ORM::factory('Iblock')
						->table_columns();
				foreach ($this->request->post() as $key => $vol) {
					if (key_exists($key, $list) && $vol != '') {
						$fields[$key] = $vol;
					}
				}
				if (count($fields) > 0) {
					Iblock::Add($fields);
				}
				$this->redirect("/admin/");
			}

			$this->template->content = View::factory('admin/v_iblock_add')
					->bind('section_id', $id)
					->bind('items', $breads);
		}

		//Редатирование инфоблока
		public function action_edit()
		{
			$arResult = ORM::factory('PropertyGroup')
					->GetListAll($this->request->param('id'));

            //удаляем группы
            if ($this->request->post('del_group')){
                IblockElementProperty::RemoveCategories($this->request->post('del_group'));
            }


			//Обновляем свойства
			if ($this->request->post('sub') == 'Сохранить') {
				Iblock::UpdateProperties($this->request->post());
				$fields = array(
						'name' => $_POST['name'],
						'description' => $_POST['preview_text'],
						'date_create' => $_POST['date_create'],
				);
				Iblock::Update($fields, $this->request->param('id'));


                //удаляем свойства
                if ($this->request->post('p_del')){
                    IblockElementProperty::RemoveProperties($this->request->post('p_del'));
                }

				$this->redirect("/admin/infoblock/edit/" . $this->request->param('id'));
			}






			//Добавляем свойства
			if ($this->request->post('sub') == 'Добавить') {
				$prop = ORM::factory('Property');
				$prop->set('name', $_POST['name']);
				$prop->set('group_id', $_POST['group_id']);
				if (isset($_POST['p_type'])) {
					$prop->set('p_type', $_POST['p_type']);
				}

				$prop->set('code', $_POST['code']);
				if (isset($_POST['many'])) {
					$prop->set('many', $_POST['many']);
				}
				if (isset($_POST['obyaz'])) {
					$prop->set('obyaz', $_POST['obyaz'] ? $_POST['obyaz'] : 0);
				}

				$prop->set('block_id', $this->request->param('id'));
				$prop->save();
				$this->redirect("/admin/infoblock/edit/" . $this->request->param('id'));
			}

			//Создаем группу
			if ($this->request->post('sub') == 'Создать группу') {
				$group = ORM::factory('PropertyGroup');
				$group->set('name', $_POST['name']);
				$group->set('block_id', $this->request->param('id'));
				$group->save();
				$this->redirect("/admin/infoblock/edit/" . $this->request->param('id'));
			}




			$iblock_id   = $this->request->param('id');
			$infoblock   = Iblock::GetByID($iblock_id);
			$prop_types  = ORM::factory('PropertyType')
					->find_all();
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

			$this->template->content = View::factory('admin/v_iblock_edit')
					->bind('gr', $gr)
					->bind('groups', $prop_groups)
					->bind('arResult', $arResult)
					->bind('element', $infoblock)
					->bind('types', $types)
					->bind('block_id', $iblock_id);

		}
	}
