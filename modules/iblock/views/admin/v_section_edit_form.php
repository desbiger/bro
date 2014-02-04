<h3 style = "margin-left: 10px">Редактирование раздела</h3>
<hr>
<?=
	View::factory('admin/breadcrumbs')
			->bind('items', $items)
			->bind('block_id', $block_id)
	; ?>
<hr>
<form method = "post" action = "/admin/info/<?=$block_id?>/section/edit/<?= $section_id ?>" enctype = "multipart/form-data">
	<div class = "tab-content">
		<div class = "tab-pane fade in active" id = "home">

			<table class = "table table-bordered table-hover">
				<tr>
					<td>Название</td>
					<td>
						<?= Form::input('name', $name, array('size' => 50)) ?>
					</td>
				</tr>
				<tr>
					<td>Описание</td>
					<td>
						<?= Form::textarea('description', $description, array('size' => 50)) ?>
					</td>
				</tr>
				<tr>
					<td>Детальная картинка</td>
					<td>
						<a href = "/upload/<?= $det_picture['name'] ?>" class = "fancy"><img src = "/upload/preview/<?= $det_picture['name'] ?>"></a>

						<?= Form::file('detail_picture'); ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<input name = "action" type = "submit" class = "btn btn-primary btn-large" value = "Сохранить">
	<input name = "action" type = "submit" class = "btn btn-primary btn-large" value = "Удалить">
	<input name = "action" type = "submit" class = "btn btn-default btn-large" value = "Отмена">
</form>

