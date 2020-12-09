<?php
	session_start();
	require_once('functions.php');
	require_once('user_functions.php');
	if ($_POST['order_request'] == '1') 
	{
		WriteOrder();
	}
	if ($_POST['exit_button'] == '1')
	{
		UserExit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Личный кабинет</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="../style-NS.css">
	<script type="text/javascript" src="control-scrypt.js"></script>
	<?php
		
	?>
</head>
<body>
	<?php
		GenerateHeader();
		CheckAuthorizationStatus('user_list.xml');
		//GenerateBody(0);
	?>
</body>
</html>