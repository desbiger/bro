<a href = "/admin/">Инфоблоки</a>
<? foreach ($items as $item): ?>
	<? if ($item['id'] && isset($item['block_id'])) { ?>
		-> <a href = "/admin/info/<?= $block_id ?>/main/index/<?= $item['id'] ?>"><?= $item['name'] ?></a>
	<? }
	else { ?>
		-> <a href = "/admin/info/<?= $item['id'] ?>"><?= $item['name'] ?></a>
	<? } ?>
<? endforeach ?>
