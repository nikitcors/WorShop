<?php
function CreateHTMLmenu($menuarray,$xml_name)
{
	/*
	чтение xml
	определение структуры меню
	*/ 
	//$JSON_obj = json_decode($_POST,true);

	//$_SESSION['ZRT'] = $JSON_obj;

	$ourFileName = "../html-templates/test.html";
	$ourFileHandle = fopen($ourFileName, 'w+') or die("Error");
	$str = "<HTML>
			<body>
			<div class='str1'>
				Работает!".htmlspecialchars(print_r($_POST, true))."
			</div>
			<div>".count($_POST)."!!!".$_POST['parent_name']."</div>
			<div>".json_encode($_POST,JSON_UNESCAPED_UNICODE)."</div> 
			<div>".$_POST['solo_name']."</div> 
			</body>
			</HTML>
		   ";
	fwrite($ourFileHandle, $str);
	fclose($ourFileHandle);
}
function ReadXmlOrderList($xml_name)
{
	$statemass = array("Заявка оставлена","Заявка рассмотрена, производится связь с клиентом","Техника поступила в мастерскую","Произведена диагностика, ожидается решение клиента","Ремонт произведен и ожидает клиента","Заявка завершена", "Отказ от ремонта");
	$xmlstruct = simplexml_load_file($xml_name);
	//echo $xmlstruct->elem[1]["value"];
	//echo $xmlstruct->elem[1]->sub_elem[0]["src"];
	//echo count($xmlstruct->elem);
	//echo count($xmlstruct->elem[1]->sub_elem);
	$ordercnt = count($xmlstruct->order);
	//echo $ordercnt;

	for ($i=0; $i < $ordercnt; $i++) 
	{ 
		if ($xmlstruct->order[$i]["state"] >= 1) 
		{
			echo "<div class='container'>".$xmlstruct->order[$i]->date." ".$xmlstruct->order[$i]->name;
			echo "<br>".$statemass[(int)$xmlstruct->order[$i]["state"]];
				echo "<div>";
					echo "Техника:".$xmlstruct->order[$i]->subject."<br>";
					echo "Описание проблемы:".$xmlstruct->order[$i]->text."<br>";
					//echo "Описание на приёме:".$xmlstruct->order[$i]->description."<br>";
					switch ($xmlstruct->order[$i]["state"]) 
					{
						case '2':
							echo "Описание на приёме:".$xmlstruct->order[$i]->description."<br>";
							echo "Диагностика:".$xmlstruct->order[$i]->problems."<br>";
							break;
						case '3':
							echo "Описание на приёме:".$xmlstruct->order[$i]->description."<br>";
							echo "Диагностика:".$xmlstruct->order[$i]->problems."<br>";
							echo "Работы:".$xmlstruct->order[$i]->repairs."<br>";
							break;
						case '4':
							echo "Описание на приёме:".$xmlstruct->order[$i]->description."<br>";
							echo "Диагностика:".$xmlstruct->order[$i]->problems."<br>";
							echo "Работы:".$xmlstruct->order[$i]->repairs."<br>";
							break;
						case '5':
							echo "Описание на приёме:".$xmlstruct->order[$i]->description."<br>";
							echo "Диагностика:".$xmlstruct->order[$i]->problems."<br>";
							echo "Работы:".$xmlstruct->order[$i]->repairs."<br>";
							echo "Комментарий:".$xmlstruct->order[$i]->comment."<br>";
							break;
						case '6':
							echo "Описание на приёме:".$xmlstruct->order[$i]->description."<br>";
							echo "Диагностика:".$xmlstruct->order[$i]->problems."<br>";
							echo "Работы:".$xmlstruct->order[$i]->repairs."<br>";
							echo "Комментарий:".$xmlstruct->order[$i]->comment."<br>";
							break;
						default:
							
							break;
					}
				echo "</div>";
			echo "</div>";
		}
	}
}
	/*
	$sub_elemcnt = 0;
	$menuarray = array("state" => array(),
					   "date" => array(),
					   "name" => array(),
					   "number" => array(),
					   "subject" => array(),
					  );

	for ($i=0; $i < $elemcnt; $i++) 
	{ 
		$sub_elemcnt = count($xmlstruct->elem[$i]->sub_elem);
		
		$menuarray["naim"][$i] = $xmlstruct->elem[$i];
		
		if ($sub_elemcnt < 1) 
		{
			$menuarray["naim"][$i] = $xmlstruct->elem[$i]["value"];
			$menuarray["position"][$i] = 0;
			$menuarray["src"][$i] = $xmlstruct->elem[$i]["src"];
		}
		else
		{
			$sub_src = array("csrc" => array());
			$sub_name = array("cname" => array());

			$menuarray["position"][$i] = 1;
			$menuarray["subnaim"][$i] = $xmlstruct->elem[$i]["value"];
			for ($y=0; $y < $sub_elemcnt; $y++) 
			{ 
				$sub_name["cname"][$y] = $xmlstruct->elem[$i]->sub_elem[$y];  
				$sub_src["csrc"][$y] = $xmlstruct->elem[$i]->sub_elem[$y]["src"]; 
			}
			$menuarray["naim"][$i] = $sub_name["cname"]; 
			$menuarray["src"][$i] = $sub_src["csrc"];
			unset($sub_src,$sub_name);
		}
	}

	
	echo "<form name='menu-table' method='post'>";
	echo "<ul class='menuarray' id='maintbl'>";
	for ($i=0; $i < count($menuarray["position"]); $i++) 
	{ 
		if ($menuarray['position'][$i] == 0) 
		{
			echo "<li tabindex='1' id='s_".$i."'>";
			echo "<div><input value='".trim($menuarray["naim"][$i])."' id='name'>, путь:<input value='".trim($menuarray["src"][$i])."' id='src'></div>";
		}
		else
		{
			echo "<li tabindex='1' id='g_".$i."'>";
			echo "<div><input id='name' value='".trim($menuarray["subnaim"][$i])."'></div>";
			echo "<ul>";
			for ($y=0; $y < count($menuarray["naim"][$i]); $y++) 
			{ 
				echo "<li tabindex='1' id='g".$i."_".$y."'>";
				echo "<div><input value='".trim($menuarray["naim"][$i][$y])."' id='name'>, путь <input value='".trim($menuarray["src"][$i][$y])."' id='src'></div>";
				echo "</li>";
			}
			echo "</ul>";
		}
		echo "</li>";
	}
	echo "</ul>";
	echo "</form>";
	*/
?>