<!--<pre>--><?// print_r($_FILES) ?><!--</pre>-->
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
<?//=View::factory('admin/breadcrumbs')->bind('items',$items);?>
<hr>
<ul class = "nav nav-tabs">
	<li class = "active">
		<a href = "#home" data-toggle = "tab">
			Инофблок
		</a>
	</li>
<!--	<li>-->
<!--		<a href = "#dop" data-toggle = "tab">-->
<!--			Дополнительные свойства-->
<!--		</a>-->
<!--	</li>-->
</ul>
<form method = "post" action="/admin/infoblock/add/" enctype = "multipart/form-data">
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
					<td class = "text-right">Описание</td>
					<td><?= Form::textarea('description') ?></td>
				</tr>
			</table>

		</div>

<!--		<div class = "tab-pane fade" id = "dop">-->
<!--			<table class = "table table-bordered">-->
<!--				<tr>-->
<!--					<td class = "text-right" >Мнемонический код элемента</td>-->
<!--					<td>--><?//= Form::input('code', null, array('size' => 50)) ?><!--</td>-->
<!--				</tr>-->
<!--			</table>-->
<!--		</div>-->
	</div>
	<hr>
	<input name = "sub" type = "submit" class = "btn btn-primary btn-large" value = "Сохранить" >
	<a class = "btn btn-default" href = "/admin/section/add">Отмена</a>
</form>