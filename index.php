<!DOCTYPE html>
<html>
<head>
	<title>Варп-мастерская</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<?php
		require_once('functions.php');
	?>
</head>
<body>
	<div class="head_area">
		<div class="info">
			Мастерская.
		</div>
		<div class="flex_txt">
			Единственным благом является знание, а единственным злом – невежество.
		</div>
	</div>
	<div class="left_area">
		<button>Личный кабинет</button>
		<button>Оставить заявку</button>
	</div>
	<div class="content_area">
		<div class="cl_post">
			<?php ReadXmlOrderList('order_list.xml');?>
		</div>
	</div>
	<div class="right_area">
		Правая
	</div>
</body>
</html>