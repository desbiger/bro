<?php
	Route::set('elements_infoblocks', 'admin/info(/<iblock_id>(/<controller>(/<action>(/<id>(/<section_id>)))))')
			->defaults(array(
					'directory' => 'admin',
					'controller' => 'main',
					'action' => 'index',
			));
	Route::set('infoblocks', 'admin(/<controller>(/<action>(/<id>(/<section_id>))))')
			->defaults(array(
					'directory' => 'admin',
					'controller' => 'infoblock',
					'action' => 'index',
			));