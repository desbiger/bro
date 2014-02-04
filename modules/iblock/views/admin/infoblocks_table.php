<h3 style = "margin-left: 10px">Управление инфоблоками</h3>
<hr>
<?//=
//	View::factory('admin/breadcrumbs')
//			->bind('items', $breadcrumbs) ?>
<hr>
<a class = "btn btn-primary btn-large" href = "/admin/infoblock/add/">Добавить инфоблок</a>

<table class = "table table-bordered table-hover">
	<thead>
	<tr>
		<th>id</th>
		<th>Название</th>
		<th>Дата создания</th>
		<th>Описание</th>
	</tr>
	</thead>
	<? $i = 0 ?>
	<tbody>
	<? if ($cur): ?>
		<tr>
			<td></td>
			<td><a href = "/admin/info/<?= $cur->section_id ?>"><span class = "folder_up"></span>...</a></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	<? endif ?>

	<? foreach ($elements as $element): ?>
		<? // $i++ ?>
		<tr>
			<td><?= $element->id ?></td>
			<td><a href = "/admin/info/<?= $element->id ?>"><span class = "element"></span><?=
						$element->name ?></a></td>
<!--			<td>--><?//= $element->name ?><!--</td>-->
			<td><?= $element->date_create ?></td>
			<td><?= $element->description ?></td>
		</tr>
	<? endforeach ?>


	</tbody>
</table>
<hr>