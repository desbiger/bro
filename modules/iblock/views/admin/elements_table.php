<h3 style = "margin-left: 10px">Элементы</h3>
<hr>
<?=
	View::factory('admin/breadcrumbs')
			->bind('items', $breadcrumbs)
			->bind('block_id', $block_id)
?>
<hr>
<a class = "btn btn-primary btn-large" href = "/admin/info/<?= $block_id ?>/element/add/<?= $section_id ?>">Добавить Элемент</a>
<a class = "btn btn-default" href = "/admin/info/<?= $block_id ?>/section/add/<?= $section_id ?>">Добавить раздел</a>
<a style="float: right" class = "btn btn-default" href = "/admin/infoblock/edit/<?= $block_id ?>">Редактировать свойства инфоблока</a>

<table class = "table table-bordered table-hover">
	<thead>
	<tr>
		<th>id</th>
		<th></th>
		<th style = "width: 170px">Название</th>
		<th>Название раздела</th>
		<th>Дата создания</th>
		<th>Описание</th>
		<th>Текст</th>
	</tr>
	</thead>
	<? $i = 0 ?>
	<tbody>
	<? if ($cur): ?>
		<tr>
			<td></td>
			<td></td>
			<td><a href = "/admin/info/<?= $block_id ?>/main/index/<?= $cur->section_id ?>"><span class = "folder_up"></span>...</a></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	<? endif ?>
	<? foreach ($sections as $vol): ?>


		<tr>
			<td style = "width: 55px">
				<?= $vol->id ?>

			</td>
			<td style = "text-align: center">
				<a title = "редактировать" href = "/admin/info/<?= $block_id ?>/section/edit/<?= $vol->id ?>">
					<span class = "folder_edit"></span>
				</a>
			</td>
			<td>
				<a href = "/admin/info/<?= $block_id ?>/main/index/<?= $vol->id ?>">
					<span class = "folder"></span>
					<?= $vol->name ?>
				</a>
			</td>
			<td><?= $vol->name ?></td>
			<td></td>
			<td><?= $vol->description ?></td>
			<td></td>
		</tr>
	<? endforeach ?>
	<? foreach ($elements as $element): ?>
		<? // $i++ ?>
		<tr>
			<td><?= $element->id ?></td>
			<td></td>
			<td>
				<a href = "/admin/info/<?= $block_id ?>/element/edit/<?= $element->id ?>/<?= $section_id ?>">
					<span class = "element"></span>
					<?= $element->name ?>
				</a>
			</td>
			<td><?= $element->name ?></td>
			<td><?= $element->date_create ?></td>
			<td><?= $element->description ?></td>
			<td><?= $element->preview_text ?></td>
		</tr>
	<? endforeach ?>


	</tbody>
</table>
<hr>