<!--<pre>--><?// print_r($_FILES) ?><!--</pre>-->
<?=$section_id?>
<h3 style = "margin-left: 10px">Добавление нового элемента</h3>
<hr>
<script type = "text/javascript">
	$(function () {
		$('.nav-tab a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
	});

</script>
<?=
	View::factory('admin/breadcrumbs')
			->bind('items', $items); ?>
<hr>
<ul class = "nav nav-tabs">
	<li class = "active">
		<a href = "#home" data-toggle = "tab">
			Элемент
		</a>
	</li>
	<li>
		<a href = "#dop" data-toggle = "tab">
			Дополнительные свойства
		</a>
	</li>
</ul>
<form method = "post" action = "/admin/info/<?= $block_id ?>/element/add/<?= $section ?>" enctype = "multipart/form-data">
	<div class = "tab-content">
		<div class = "tab-pane fade in active" id = "home">

			<table class = "table table-bordered table-hover">
				<tr>
					<td class = "text-right">Название</td>
					<td><?= Form::input('name', null, array('size' => 50)) ?></td>
				</tr>
				<tr>
					<td class = "text-right">Дата создания</td>
					<td>
						<?= Form::input('date_create', null, array('size' => 50)) ?></td>
				</tr>
				<tr>
					<td>Раздел</td>
					<td><?= Form::select('section_id', $sections, $section) ?></td>
				</tr>
				<tr>
					<td class = "text-right">Описание</td>
					<td><?= Form::textarea('preview_text') ?></td>
				</tr>
				<tr>
					<td class = "text-right">Полное описание</td>
					<td><?= Form::textarea('detail_text') ?></td>
				</tr>
				<tr>
					<td class = "text-right">Картинка превью</td>
					<td>

						<?= Form::file('preview_picture') ?>
					</td>
				</tr>
				<tr>
					<td class = "text-right">Детальная картинка</td>
					<td>

						<?= Form::file('detail_picture') ?></td>

				</tr>
			</table>

		</div>

		<div class = "tab-pane fade" id = "dop">
			<!--						<pre>--><?// print_r($props) ?><!--</pre>-->
			<? foreach ($props as $k => $p): ?>
				<!--				--><? //die?>
				<? if (is_array($p[1])): ?>
					<h4><?= $k ?></h4>
					<table class = "table table-bordered">
						<? foreach ($p[1] as $p_list): ?>

							<tr>
								<td class = "text-right"><?= $p_list['name'] ?></td>
								<td><?=
										View::factory('admin/propertyTypes/' . $p_list['p_type'], array(
												'name' => 'prop_' . $p_list['id'],
												'value' => ''
										)) ?>
								</td>
							</tr>
						<? endforeach ?>
					</table>
				<? endif ?>
			<? endforeach ?>
		</div>
	</div>
	<hr>
	<input name = "sub" type = "submit" class = "btn btn-primary btn-large" value = "Сохранить">
	<a class = "btn btn-default" href = "/admin/section/add">Отмена</a>
</form>