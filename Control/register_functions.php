<?php
function GenerateTop()
{
	echo "<div>Регистрация</div>";
	echo "<div class='rinf'>Номер телефона указывается с цифрой 8, либо +7.</div>";
	echo "<div class='rinfo'>Пароль должен быть не менее 4х символов.</div>";
	echo "<div class='rinfo'>Пробелы не учитываются.</div>";
}
function GenerateBottom()
{
	echo "Никнейм<br><input type='text' placeholder='Реальное или придуманное имя' name='nickname'><br>";
	echo "Логин(номер телефона для связи)<br><input type='text' placeholder='Номер телефона' name='login'>";
	echo "<br>Пароль";
	echo "<br><input type='password' placeholder='Пароль'' name='password'>";
	echo "<br><button type='submit' name='request_user_data' value='1'>Зарегистрироваться</button>";
}
function GenerateAcceptMessage($login,$password,$nickname)
{
	echo "<div class='accept_info'>".$nickname." - Вы успешно зарегистрировались!</div>";
	echo "<div class='accept_info'>Ваш логин и пароль для доступа в личный кабинет:</div>";
	echo "<div class='lp'>Логин: ".$login."</div>";
	echo "<div class='lp'>Пароль: ".$password."</div>";
	echo "<div>Преходите в <a class='lk_link' href='http://localhost/WarpWorkshop/control/index.php'>личный кабинет!</a></div><br>";
}
function CheckName($xml_name)
{
	if ($_POST['login'] and $_POST['password'] and $_POST['nickname'])
	{	
		if ((strlen(trim($_POST['login'])) >= 11) and (strlen(trim($_POST['password'])) >= 4) and (strlen(trim($_POST['nickname'])) >= 1))
		{
			$xmlstruct = simplexml_load_file($xml_name);
			$cnt = count($xmlstruct->user);
			$conformity = 0;

			for ($i=0; $i < $cnt; $i++) 
			{ 
				if (trim($_POST['login']) == trim($xmlstruct->user[$i]->login)) 
				{
					$conformity = 1;
					break;
				}			
			}

			for ($i=0; $i < $cnt; $i++) 
			{ 
				if (trim($_POST['nickname']) == trim($xmlstruct->user[$i]->nickname)) 
				{
					if ($conformity == 1) 
					{
						$conformity = $conformity + 3;
					}
					else
					{
						$conformity = 3;
					}
					break;
				}			
			}

			switch ($conformity) 
			{
				case 0:
					RegisterUser(trim($_POST['login']),trim($_POST['password']),trim($_POST['nickname']),$xml_name);
					break;
				case 1:
					GenerateTop();
					GenerateError(2);
					GenerateBottom();
					break;
				case 2:
					GenerateTop();
					GenerateError(3);
					GenerateBottom();
					break;
				case 3:
					GenerateTop();
					GenerateError(4);
					GenerateBottom();
					break;
			}
			/*
			if ($conformity == 0) 
			{
				RegisterUser($_POST['login'],$_POST['password'],$xml_name);
			}
			else
			{
				GenerateTop();
				GenerateError(2);
				GenerateBottom();
			}
			*/
		}
		else
		{
			GenerateTop();
			GenerateError(1);
			GenerateBottom();		
		}
	}
	else
	{
		GenerateTop();
		GenerateError(0);
		GenerateBottom();
	}
}
function GenerateError($state)
{
	echo "<div class='errinfo'>";
	switch ($state) 
	{
		case '0':
			echo "Вы не ввели номер никнейм, телефона или пароль!";
			break;
		case '1':
			echo "Никнейм, Номер телефона или пароль слишком короткие, либо содержат недопустимые символы!";
			break;
		case '2':
			echo "Такой номер телефона уже существует в базе данных!";
			break;
		case '3':
			echo "Такой никнейм уже существует в базе данных!";
			break;
		case '4':
			echo "Такой номер телефона и никнейм уже существуют в базе данных!";
			break;
	}
	echo "</div>";
}
function RegisterUser($login,$password,$nickname,$xml_name)
{
	
	$xmlstruct = simplexml_load_file($xml_name);
	$cnt = count($xmlstruct->user);
	$xmlstruct->addChild("user");
	$xmlstruct->user[$cnt]->addChild("nickname",$nickname);
	$xmlstruct->user[$cnt]->addChild("login",$login);
	$xmlstruct->user[$cnt]->addChild("password",$password);
	$xmlstruct->user[$cnt]->addChild("admission",'0');
	$xmlstruct->asXML($xml_name);
	
	GenerateAcceptMessage($login,$password,$nickname);
}
?>