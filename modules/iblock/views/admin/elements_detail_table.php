<!--<pre>--><?// print_r($props) ?><!--</pre>-->
<h3 style = "margin-left: 10px"><?= $element->name ?></h3>
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
			->bind('items', $items)
			->bind('block_id', $block_id);
?>
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
					<td>Раздел</td>
					<td><?= Form::select('section_id', $sections, $section) ?></td>
				</tr>
				<tr>
					<td class = "text-right">Описание</td>
					<td><?= Form::textarea('preview_text', $element->preview_text) ?></td>
				</tr>
				<tr>
					<td class = "text-right">Полное описание</td>
					<td><?= Form::textarea('detail_text', $element->detail_text, array('class' => 'textedit')) ?></td>
				</tr>
				<tr>
					<td class = "text-right">Картинка превью</td>
					<td>
						<a href = "/upload/<?= $pre_picture['name'] ?>" class = "fancy"><img src = "/upload/preview/<?=
								$pre_picture['name']
							?>"></a>
						<?= Form::file('preview_picture') ?>
					</td>
				</tr>
				<tr>
					<td class = "text-right">Детальная картинка</td>
					<td>
						<a href = "/upload/<?= $det_picture['name'] ?>" class = "fancy"><img src = "/upload/preview/<?= $det_picture['name'] ?>"></a>
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
							<?
							$array = array();

							$array = array(
									'name' => 'prop_' . $element->id . '_' . $p_list['id'],
									'value' => ORM::factory('PropertyValue')
													->GetValue($element->id, $p_list['id'])->value
							);
							if ($p_list['many']) {
								$array['multiple'] = true;
								$array['value']    = IblockElementProperty::GetValues(Array(
										'element_id' => $element->id,
										'property_id' => $p_list['id']
								));
//								echo "<pre>".print_r($array['value'],true)."</pre>";
//								die;
							}
							?>

							<tr>
								<td class = "text-right"><?= $p_list['name'] ?></td>
								<td><?=
										View::factory('admin/propertyTypes/' . $p_list['p_type'], $array) ?>
								</td>
							</tr>

						<? endforeach ?>
					</table>
				<? endif ?>
			<? endforeach ?>

		</div>
	</div>
	<hr>
	<input name = "sub" type = "submit" class = "btn btn-primary btn-large" value = "Сохранить" href = "/admin/infoblock/add">
	<a class = "btn btn-default" href = "/admin/section/add">Отмена</a>
</form>