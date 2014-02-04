<?php defined('SYSPATH') or die('No direct script access.');

	class Controller_Admin_Section extends Controller_Admin_Base
	{
		public function before()
		{
			parent::before();
			$this->template->content = '';
		}

		public function action_index()
		{
		}

		public function action_edit()
		{
			$block_id = $this->request->param('iblock_id');
			if ($this->request->post('action') == 'Сохранить') {

				$fields = array(
						'name' => $this->request->post('name'),
						'description' => $this->request->post('description'),
				);

				$file = ORM::factory('File');
				foreach ($_FILES as $k => $v) {
					$id         = $file->UploadAndAdd($k);
					$fields[$k] = $id;
				}

				$res = IblockSection::Edit($fields, $this->request->param('id'));
				$this->redirect('/admin/info/'.$this->request->param('iblock_id').'/section/edit/' . $this->request->param('id'));
			}
			else {


				$section_id = $this->request->param('id');
				$section    = IblockSection::GetByID($section_id)
						->as_array();

				$detail_picture = ORM::factory('File', $section['detail_picture'])
						->as_array();
				if ($detail_picture['size'] > 0) {
					Image::factory(DOCROOT . "upload/" . $detail_picture['name'])
							->resize('100', '100')
							->save(DOCROOT . 'upload/preview/' . $detail_picture['name']);
				}

				$items = Breadcrumbs::GetPath($section_id,$this->request->param('iblock_id'));


				$content = View::factory('admin/v_section_edit_form')
						->bind('name', $section['name'])
						->bind('block_id', $block_id)
						->bind('section_id', $section['id'])
						->bind('items', $items)
						->bind('det_picture', $detail_picture)
						->bind('description', $section['description']);

				$this->template->content = $content;
			}
		}

		public function action_add()
		{
			$id       = $this->request->param('id') ? $this->request->param('id') : 0;
			$block_id = $this->request->param('iblock_id');

			if ($this->request->post('sub')) {
				$new_section = ORM::factory('Section');
				foreach ($this->request->post() as $key => $vol) {
					if ($key != 'sub') {
						$new_section->set($key, $vol);
					}
				}
				$new_section->set('section_id', $id);
				$new_section->set('block_id', $this->request->param('iblock_id'));
				$new_section->save();
				$this->redirect("/admin/info/" . $block_id . "/main/index/{$id}");
			}


			$items                   = Breadcrumbs::GetPath($id,$this->request->param('iblock_id'));
			$this->template->content = View::factory('admin/v_section_add_form')
					->bind('section_id', $id)
					->bind('block_id', $block_id)
					->bind('block_id', $block_id)
					->bind('items', $items);
			if ($this->request->post()) {
				foreach ($this->request->post() as $key => $vol) {
					echo $key . " = " . $vol . "<br>";
				}
			}
		}
	}