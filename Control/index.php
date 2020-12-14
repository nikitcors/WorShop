<?php
	session_start();
	require_once('functions.php');
	require_once('user_functions.php');
	require_once('admin_functions.php');

	if ($_POST['ActionForm_request'] >= 0) 
	{
		WriteInfoAction();
	}
	if ($_POST['CancelForm_request'] >= 0) 
	{
		WriteInfoCancel();
	}
	if ($_POST['FinalForm_request'] >= 0) 
	{
		WriteInfoFinal();
	}
	if ($_POST['order_request'] == '1') 
	{
		WriteOrder();
	}
	if ($_POST['comment_request'] >= 0) 
	{
		WriteComment();
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