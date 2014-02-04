<? if (isset($value) && !isset($multiple)): ?>
	<? $img = ORM::factory('file', $value) ?>
	<a class = "fancy" href = "<?= "/upload/" . $img->name ?>">
		<img src = "<?= "/upload/" . $img->name ?>" width = "150" height = "150">
	</a>
	<?= Form::file($name) ?>
<?
elseif (isset($value) && isset($multiple)):?>
	<? foreach ($value as $v): ?>
		<? $img = ORM::factory('file', $v->value) ?>
		<a class = "fancy" href = "<?= "/upload/" . $img->name ?>">
			<img src = "<?= "/upload/" . $img->name ?>" width = "150" height = "150">
		</a>
		<?= Form::file($name . "_" . $v->id) ?>
	<? endforeach ?>
	<hr>
	<?= Form::file($name . "[]") ?>
	<?= Form::file($name . "[]") ?>
	<?= Form::file($name . "[]") ?>
	<?= Form::file($name . "[]") ?>
<? endif ?>

 