<!--<pre>--><?// print_r($_FILES) ?><!--</pre>-->
<h3 style = "margin-left: 10px"><?= $element->name ?></h3>
<hr>
<? $props = ORM::factory('Property')
		->where('block_id', "=", $element->id)
		->order_by('group_id')
		->find_all();

	//		$element->properties->order_by('type')->find_all()

?>
<pre><? print_r($gr) ?></pre>
<script type = "text/javascript">
	$(function () {
		$('.nav-tab a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
	});

</script>

<script type = "text/javascript">
	$(function () {
		$('a.btn-default').click(function () {
			$('#prop_add input[name=group_id]').attr('value', ($(this).attr('rel')));
		})
	});
</script>
<? //= View::factory('admin/breadcrumbs')
	//		->bind('items', $items)
	//		->bind('block_id', $block_id);
	//
?>
<hr>
<ul class = "nav nav-tabs">
	<li class = "active">
		<a href = "#home" data-toggle = "tab">
			Инфоблок
		</a>
	</li>
	<li>
		<a href = "#dop" data-toggle = "tab">
			Дополнительные свойства
		</a>
	</li>
</ul>

<form method = "post" enctype = "multipart/form-data">
	<div class = "tab-content">
		<div class = "tab-pane fade in active" id = "home">

			<table class = "table table-bordered table-hover">
				<tr>
					<td class = "text-right">Название</td>
					<td><?= Form::input('name', $element->name, array('size' => 50)) ?></td>
				</tr>
				<tr>
					<td class = "text-right">Дата создания</td>
					<td>
						<?= Form::input('date_create', $element->date_create, array('size' => 50)) ?></td>
				</tr>
				<tr>
					<td class = "text-right">Описание</td>
					<td><?= Form::textarea('preview_text', $element->description) ?></td>
				</tr>


			</table>

		</div>

		<div class = "tab-pane fade" id = "dop">

			<? if ($props->count() > 0): ?>
				<?
				$prop_groups = ORM::factory('PropertyGroup')
						->where('block_id', "=", $element->id)
						->find_all();

				$cur_group = '';
				$i         = 0;
				?>
				<? foreach ($props as $kk => $vol): ?>
					<?
					$i++;
					$groups   = array();
					$groups[] = '';
					foreach ($prop_groups as $g) {
						$groups[$g->id] = $g->name;
					}
					?>
					<? if ($cur_group != $vol->group_id): ?>

						<? if ($i != 1): ?>
							<tr>
								<td></td>
								<td align = "left" colspan = "6">
									<a class = "btn-default btn fancy" rel = "<?= $cur_group ?>" href = "#prop_add">Добавить
									                                                                                свойство</a>
								</td>
							</tr>
							</table>

						<? endif ?>
						<? $cur_group = $vol->group_id; ?>

						<h4><?= $vol->PropertyGroup->name ?></h4>


						<table class = "table table-bordered">
						<tr>
							<td></td>
							<td>Название</td>
							<td>Тип</td>
							<td>Множественное</td>
							<td>Обязательное</td>
							<td>Код</td>
							<td>Группа</td>
						</tr>

					<? endif ?>
					<tr>
						<td class = "text-right"><?= $vol->id ?></td>
						<td><?= Form::input('name_' . $vol->id, $vol->name) ?></td>
						<td><?= Form::select('p_type_' . $vol->id, $types, $vol->PropertyType->id) ?></td>
						<td><?= Form::checkbox('many_' . $vol->id, 1, (bool)$vol->many) ?></td>
						<td><?= Form::checkbox('obyaz_' . $vol->id, 1, (bool)$vol->obyaz) ?></td>
						<td><?= Form::input('code_' . $vol->id, $vol->code) ?></td>
						<td><?= Form::select('group_id_' . $vol->id, $groups, $vol->PropertyGroup->id) ?></td>
					</tr>


				<? endforeach ?>

				<tr>
					<td></td>
					<td align = "left" colspan = "6">
						<a class = "btn-default btn fancy" rel = "<?= $cur_group ?>" href = "#prop_add">
							Добавить свойство
						</a>
					</td>
				</tr>
				</table>
				<?else:?>
				<a class = "btn-default btn fancy" href = "#prop_add">
											Добавить свойство
										</a>
			<? endif ?>
			<a class = "btn-default btn fancy" href = "#group_add">Добавить группу</a>
		</div>
	</div>
	<hr>
	<input name = "sub" type = "submit" class = "btn btn-primary btn-large" value = "Сохранить" href = "/admin/infoblock/add">
	<a class = "btn btn-default" href = "/admin/section/add">Отмена</a>
</form>
<div style = "display: none;">
	<form method = "post" id = "prop_add">
		<input type = "hidden" name = "group_id" value = "">

		<h2>Новое свойство элемента инфоблока</h2>
		<table style = "width: 800px" class = "table table-bordered table-hover">
			<tr>
				<td>Название</td>
				<td>Тип</td>
				<td>Множественное</td>
				<td>Обязательное</td>
				<td>Код</td>
			</tr>
			<tr>
				<td><?= Form::input('name') ?></td>
				<td><?= Form::select('p_type', $types) ?></td>
				<td><?= Form::checkbox('many') ?></td>
				<td><?= Form::checkbox('obyaz') ?></td>
				<td><?= Form::input('code') ?></td>

			</tr>
		</table>
		<?= Form::submit('sub', 'Добавить') ?>
	</form>
	<form method = "post" id = "group_add">
		<input type = "hidden" name = "group_id" value = "">

		<h2>Новое группа свойств элементов инфоблока</h2>
		<table style = "width: 800px" class = "table table-bordered table-hover">
			<tr>
				<td>Название</td>

			</tr>
			<tr>
				<td><?= Form::input('name') ?></td>
			</tr>
		</table>
		<?= Form::submit('sub', 'Создать группу') ?>
	</form>
</div>