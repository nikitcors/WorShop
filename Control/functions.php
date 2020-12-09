<?php
function CheckAuthorizationStatus($xml_name)
{
	if ((isset($_COOKIE['login']) and isset($_COOKIE['state'])) or (isset($_SESSION['login']) and isset($_SESSION['state']))) 
	{
		if ($_COOKIE['login']) 
		{
			$_SESSION['login'] = $_COOKIE['login'];
			$_SESSION['state'] = $_COOKIE['state'];
		}
		GenerateBody();
	}
	else
	{
		Authorization($xml_name);
	}
}
function GenerateErrorAlert($state)
{
	switch ($state) 
	{
		case '1':
			echo "<div style='color:red;font-size: 16px;'>Ошибка авторизации! Неверен логин или пароль!</div>";
			break;
		case '2':
			echo "<div style='color:red;font-size: 16px;'>Ошибка авторизации! Вы не ввели логин или пароль!</div>";	
			break;
		default:
			break;
	}
}
function GenerateHeader()
{
	echo "<div class='head' align='center' valign='middle'>
	Личный кабинет
	<div style='position: absolute;top: 20%;''>
		<a class='home' href='http://localhost/WarpWorkshop'>На главную</a>
	</div>
	</div>";
}
function GenerateBody($xml_name)
{	
	$Login = $_SESSION['login'] > $_POST['login'] ? $_SESSION['login']: $_POST['login'];
	$Admission = trim(GetAdmission($_SESSION['login'] > $_POST['login'] ? $_SESSION['login']: $_POST['login']));
	echo "<div class='left_area'>";
	switch (trim(GetAdmission($_SESSION['login'] > $_POST['login'] ? $_SESSION['login']: $_POST['login']))) 
	{
		case '0':
			echo "<div>Пользователь ".$_SESSION['nickname']."</div>";
			echo "<input type='button' value='Подать заявку' onclick='ToggleOrderForm()'>";
			break;
		case '1':
			echo "<div>Администратор ".$_SESSION['nickname']."</div>";
			echo "<input type='button' value='Просмотр заявок'>";
			break;
		default:
			GenerateErrorAlert();
			GenerateAuthorizationArea(1);
			break;
	}
	GenerateExitButton();
	echo "</div>";
	//echo $Admission." ".$Login;
	GenerateOrderList($Admission,$Login);
	//GenerateUserInfo(GetUserInfo($_SESSION['login'] > $_POST['login'] ? $_SESSION['login']: $_POST['login']));
}
function GenerateExitButton()
{
	echo "<form method='POST'>";
		echo "<button class='exit_button' name='exit_button' value='1'>Выйти</button>";
	echo "</from>";
}
function GenerateAuthorizationArea($state)
{
	echo "<div class='container_authorization_form'>";
		echo "<form name='authorization' method='POST'>";
			echo "<div>Авторизация</div>";
			GenerateErrorAlert($state);
			echo "Логин";
			echo "<br>";
			echo "<input type='text' placeholder='Логин' name='login'>";
			echo "<br>";
			echo "Пароль";
			echo "<br>";
			echo "<input type='password' placeholder='Пароль' name='password'>";
			echo "<br>";
			echo "<input type='checkbox' name='remember'> Запомнить";
			echo "<br>";
			echo "<button type='submit'>Войти</button>";
			echo "<input type='button' value='Отмена'>";
		echo "</form>";
	echo "</div>";
}
function Authorization($xml_name)
{
	if ($_POST['login'] and $_POST['password']) 
	{
		$Login = $_POST['login'];
		$Password = $_POST['password'];

		$xmlstruct = simplexml_load_file($xml_name);

		$_SESSION['xml_name'] = $xml_name;

		$usercnt = count($xmlstruct->user);
		//echo $xml_name;
		//echo $usercnt;
		//echo " ".$Login." ".gettype($Login)." ".$Password;
		//echo $xmlstruct->list->user[2]->login;
		for ($i=0; $i < $usercnt; $i++) 
		{ 
			$lgt = trim((string) $xmlstruct->user[$i]->login);
			$pst = trim((string) $xmlstruct->user[$i]->password);
			
			if (($lgt == $Login) and ($pst == $Password)) 
			{
				$admission = (string) $xmlstruct->user[$i]->admission;
				$nickname = (string) $xmlstruct->user[$i]->nickname;
				break;	
			}
		}
		
		if ($admission) 
		{
			if (isset($_POST['remember'])) 
			{
				RememberUser();
			}
			$_SESSION['nickname'] = $nickname;
			GenerateBody();
			LogedUser($Login,1);
		}
		else
		{
			GenerateAuthorizationArea(1);
		}
	}
	else
	{
		if ($_POST['login'] or $_POST['password']) 
		{
			GenerateAuthorizationArea(2);
		}
		else
		{
			GenerateAuthorizationArea(0);
		}
	}
}
function GetAdmission($Login)
{
	$xmlstruct = simplexml_load_file($_SESSION['xml_name']);
	$usercnt = count($xmlstruct->user);

	for ($i=0; $i < $usercnt; $i++) 
	{ 
		//echo $xmlstruct->user[$i]->admission;
		if (trim((string)$xmlstruct->user[$i]->login) == $Login) 
		{
			$admission = $xmlstruct->user[$i]->admission;
			break;	
		}
	}
	//echo $admission."!";
	return $admission;
}
function GetUserInfo($Login)
{
	$xmlstruct = simplexml_load_file($_SESSION['xml_name']);
	$usercnt = count($xmlstruct->user);

	for ($i=0; $i < $usercnt; $i++) 
	{ 
		if ($xmlstruct->user[$i]->login == $Login) 
		{
			$info = $xmlstruct->user[$i]->nickname;
			break;	
		}
	}
	
	return $info;
}
function GenerateOrderList($admission,$Login)
{
	$statemass = array("Заявка оставлена","Заявка рассмотрена, производится связь с клиентом","Техника поступила в мастерскую","Произведена диагностика, ожидается решение клиента","Ремонт произведен и ожидает клиента","Заявка завершена", "Отказ от ремонта");
	echo "<div class='user_info'>";
	switch ($admission) 
	{
		case '0':
			// генерировать в теле созданные заявки юзром
			// кнопка создать заявку выдаёт форму подачи заявки на ремонт
			GenerateForms();
			$xmlstruct = simplexml_load_file('../order_list.xml');
			$cnt = count($xmlstruct->order);
			$userordercounter = 0;
			$orderlist = array();
			for ($i=0; $i < $cnt; $i++) 
			{ 
				if (trim((string) $xmlstruct->order[$i]->number) == $Login) 
				{
					$orderlist[$userordercounter] = $i;
					$userordercounter++;
				}
			}
			for ($i=0; $i < count($orderlist); $i++) 
			{ 
				switch ($xmlstruct->order[$orderlist[$i]]['state']) 
				{
					case '0':
					case '1':
						echo "<div class='container'>";
							echo "<div id='".$xmlstruct->order[$orderlist[$i]]['id']."'>Статус:".$statemass[(int) $xmlstruct->order[$orderlist[$i]]['state']]."</div><br>";
							//echo "Описание на приёме:".$xmlstruct->order[$orderlist[$i]]->description."<br>";
							echo "Техника:".$xmlstruct->order[$orderlist[$i]]->subject."<br>";
							//echo "Работы:".$xmlstruct->order[$orderlist[$i]]->repairs."<br>";
						echo "</div>";
						break;
					case '2':
						echo "<div class='container'>";
							echo "<div id='".$xmlstruct->order[$orderlist[$i]]['id']."'>Статус:".$statemass[(int) $xmlstruct->order[$orderlist[$i]]['state']]."</div><br>";
							echo "Техника:".$xmlstruct->order[$orderlist[$i]]->subject."<br>";
							echo "Описание на приёме:".$xmlstruct->order[$orderlist[$i]]->description."<br>";
							echo "Диагностика:".$xmlstruct->order[$orderlist[$i]]->problems."<br>";
							echo "Работы:".$xmlstruct->order[$orderlist[$i]]->repairs."<br>";
						echo "</div>";
						break;
					case '3':
					case '4':
						echo "<div class='container'>";
							echo "<div id='".$xmlstruct->order[$orderlist[$i]]['id']."'>Статус:".$statemass[(int) $xmlstruct->order[$orderlist[$i]]['state']]."</div><br>";
							echo "Техника:".$xmlstruct->order[$orderlist[$i]]->subject."<br>";
							echo "Описание на приёме:".$xmlstruct->order[$orderlist[$i]]->description."<br>";
							echo "Диагностика:".$xmlstruct->order[$orderlist[$i]]->problems."<br>";
							echo "Работы:".$xmlstruct->order[$orderlist[$i]]->repairs."<br>";
						echo "</div>";
						break;
					case '5':
					case '6':
						echo "<div class='container'>";
							echo "<div id='".$xmlstruct->order[$orderlist[$i]]['id']."'>Статус:".$statemass[(int) $xmlstruct->order[$orderlist[$i]]['state']]."</div><br>";
							echo "Описание на приёме:".$xmlstruct->order[$orderlist[$i]]->description."<br>";
							echo "Диагностика:".$xmlstruct->order[$orderlist[$i]]->problems."<br>";
							echo "Работы:".$xmlstruct->order[$orderlist[$i]]->repairs."<br>";
							echo "Комментарий:".$xmlstruct->order[$orderlist[$i]]->comment."<br>";
							echo "<input type='button' value='Комментарий' onclick='ToggleCommentForm(".$xmlstruct->order[$orderlist[$i]]['id'].")'>";
						echo "</div>";
						break;
				}
			}
			break;
		case '1':
			// генерировать принятые конкретным мастером заявки
			// кнопка "Просмотр заявок" показывает новые, необработанные заявки
			break;
	}
	echo "</div>";
}
function GenerateUserInfo($InfoArray)
{
	echo "<div class='user_info'>";
		
	echo "</di>";
}
function LogedUser($Login,$State)
{
	$_SESSION['login'] = $Login;
	$_SESSION['state'] = $State;
}
function RememberUser()
{
	setcookie("login",$_POST['login'], strtotime("+360 day"));
	setcookie("state",1, strtotime("+360 day"));
}
function RemoveRememberUser()
{
	setcookie("login", '', strtotime("-360 day"));
	setcookie("state", '', strtotime("-360 day"));
}
function UserExit()
{
	RemoveRememberUser();
	session_unset($_SESSION['login']);
	session_unset($_SESSION['state']);
	session_destroy();
	header("Refresh: 0");
}
?>