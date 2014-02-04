<!DOCTYPE html>
<html>
<head>
	<title>Админка</title>
	<script type = "text/javascript" src = "/include/js/jquery-1.10.2.js"></script>
	<script type = "text/javascript" src = "/include/js/bootstrap.js"></script>
	<script type = "text/javascript" src = "/include/js/jquery.fancybox.js"></script>
	<script type = "text/javascript" src = "/include/js/tinymce/tinymce.min.js"></script>

	<link type = "text/css" rel = "stylesheet" href = "/include/css/style.css">
	<link type = "text/css" rel = "stylesheet" href = "/include/css/fancybox/jquery.fancybox.css">
	<link type = "text/css" rel = "stylesheet" href = "/include/css/bootstrap-theme.css">
	<link type = "text/css" rel = "stylesheet" href = "/include/css/bootstrap.min.css">
	<link type = "text/css" rel = "stylesheet" href = "/include/css/bootstrap-theme.min.css">
	<link type = "text/css" rel = "stylesheet" href = "/include/css/bootstrap.css">


	<link rel = "stylesheet" href = "http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<!--	<script src = "http://code.jquery.com/jquery-1.9.1.js"></script>-->
	<script src = "http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


	<?
		$files = ORM::factory('File')
				->find_all();
		foreach ($files as $vol) {
			$array[] = array(
					'title' => $vol->name,
					'value' => DOCROOT . 'upload/' . $vol->name,
			);
		}
		$file_list = json_encode($array);
	?>
	<script type = "text/javascript">
		$(function () {

			$( "input[name=date_create]" ).datepicker(
					{ dateFormat: "yy-mm-dd" }
			);

			$('.fancy').fancybox();
			tinymce.init(
					{
						selector: 'textarea',
						plugins: "advlist,autolink,link,image,lists,charmap,print,preview,hr,anchor,pagebreak,spellchecker," +
								"searchreplace," +
								"wordcount,visualblocks,visualchars,code,fullscreen,insertdatetime,media,nonbreaking,save,table,contextmenu,directionality,emoticons,template,paste,textcolor",
						image_list: <?=$file_list?>,
						image_advtab: true,
						paste_data_images: true,
						content_css: '/include/css/bootstrap-theme.css, ' +
								'/include/css/bootstrap-theme.min.css, /include/css/bootstrap.css',
						language_url: '/include/js/tinymce/langs/ru.js',
						height: 400,
						width: 700
					});
		})
	</script>
</head>
<body>
<div class = "header">

</div>
<div class = "container">

	<h1 style = "color: white"><?= $title ?></h1>

	<div style = "height: 50px" class = "clearfix"></div>
	<!--<pre>--><?// print_r($elements) ?><!--</pre>-->
	<div class = "left_row"><?= $left_row ?></div>
	<div class = "right_row modal-content" style = "padding: 20px"><?= $content ?></div>
</div>
</body>
</html>