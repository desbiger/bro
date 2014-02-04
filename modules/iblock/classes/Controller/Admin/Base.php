<?php defined('SYSPATH') or die('No direct script access.');

	class Controller_Admin_Base extends Controller_Template
	{
		public $template = "admin/main";

		public function before()
		{
			if(Auth::instance()->logged_in()){
				parent::before();
				$this->template->title    = "Админка";
				$this->template->left_row = View::factory('admin/left_menu');
				$this->template->content  = "";
			}else{
				$this->redirect('admin/login');
			}
		}

	}