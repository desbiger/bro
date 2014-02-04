<?php defined('SYSPATH') or die('No direct script access.');

	class Controller_Admin_Login extends Controller_Template
	{
		public function before()
		{
			$this->template = 'admin/login';
			parent::before();
			$this->template->content = '';


		}

		public function action_index()
		{
			$this->template->content = View::factory('admin/modules/login_form');
		}

		public function action_login()
		{
			Auth::instance()
					->login($this->request->post('username'), $this->request->post('password'), true);

			$this->redirect('/admin/');

		}

		public function action_logout()
		{
			Auth::instance()
					->logout();
			$this->redirect('/admin/');
		}

		public function action_UserAdd()
		{
			$this->template->content = View::factory('admin/modules/reg_form');

			if ($_POST) {

				try {
					$user = ORM::factory('User');
					$user->create_user($_POST, array(
							'username',
							'password',
						//							'password_confirm',
							'email',
					));
					$role = ORM::factory('Role')
							->where('name', "=", "login")
							->find();
					$user->add('roles', $role);
					$this->action_login();
					$this->redirect('/admin/');
				} catch (ORM_Validation_Exception $e) {
					print_r($e->errors('auth'));
				}

			}

		}
	}