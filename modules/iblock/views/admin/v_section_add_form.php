<h3 style = "margin-left: 10px">Добавление нового раздела</h3>
<hr>
<?=View::factory('admin/breadcrumbs')
		->bind('items',$items)
		->bind('block_id',$block_id)
;?>
<hr>
<form method = "post" action = "/admin/info/<?=$block_id?>/section/add/<?= $section_id ?>" enctype = "multipart/form-data">
	<div class = "tab-content">
		<div class = "tab-pane fade in active" id = "home">

			<table class = "table table-bordered table-hover">
				<tr>
					<td>Название</td>
					<td>
						<?=Form::input('name',null,array('size'=>50))?>
					</td>
				</tr>
				<tr>
					<td>Описание</td>
					<td>
						<?=Form::textarea('description',null,array('size'=>50))?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<input name = "sub" type = "submit" class = "btn btn-primary btn-large" value = "Сохранить" >
</form>

