<?php
	require_once('register_functions.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Регистрация</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="style-reg.css">
	<link rel="stylesheet" type="text/css" href="../style-NS.css">
	<script type="text/javascript" src="control-scrypt.js"></script>
</head>
<body>
	<div class="container_authorization_form">
			<form name="authorization" method="POST">
				<?php
					if ($_POST['request_user_data']) 
					{
						CheckName('user_list.xml');
					}
					else
					{
						GenerateTop();
						GenerateBottom();
					}
				?>
				<input type="button" value="На главную" onclick='document.location.href = "http://localhost/WarpWorkshop/index.php"'>
			</form>
		</div>
</body>
</html>