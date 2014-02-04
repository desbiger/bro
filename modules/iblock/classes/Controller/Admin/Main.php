<?php defined('SYSPATH') or die('No direct script access.');

	class Controller_Admin_Main extends Controller_Admin_Base
	{
		public $template = "admin/main";

		public function before()
		{
			parent::before();
			$this->template->left_row = View::factory('admin/left_menu');
			$this->template->content  = '';
			$this->template->elements = ORM::factory('Element')
					->find_all();
			$this->template->title    = "BRO-CMS";
		}

		public function action_index()
		{

			if ($id = $this->request->param('id')) {
				$filter      = array('section_id' => $id);
				$cur_section = IblockSection::GetByID($id);
				$breadcrumbs = Breadcrumbs::GetPath($cur_section, $this->request->param('iblock_id'));
			}
			else {
				$section_id  = $this->request->param('section_id') ? $this->request->param('section_id') : 0;
				$filter      = array(
						'block_id' => $this->request->param('iblock_id'),
						'section_id' => $section_id
				);
				$breadcrumbs = Breadcrumbs::GetParent(0);
			}

			$block_id = $this->request->param('iblock_id');
			$sections = IblockSection::GetList($filter);
			$elements = IblockElement::GetList($filter);

			$this->template->content = View::factory('admin/elements_table')
					->bind('elements', $elements)
					->bind('block_id', $block_id)
					->bind('sections', $sections)
					->bind('cur', $cur_section)
					->bind('section_id', $id)
					->bind('breadcrumbs', $breadcrumbs);;
		}
	}
 