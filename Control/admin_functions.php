<?php
function GenerateAdminForms()
{
	echo "<div class='invisible_container' id='invisible_container'>";
	GenerateActionForm();
	GenerateCancelForm();
	GenerateFinalForm();
	echo "</div>";
}
function WriteInfoAction()
{
	$xmlstruct = simplexml_load_file('../order_list.xml');
	$cnt = count($xmlstruct->order);
	$ordernumber = $_POST['ActionForm_request'];
	//$order_description = $_POST['description'];
	//$order_problems = $_POST['problems'];
	//$order_repairs = $_POST['repairs'];
	//$order_price = $_POST['price'];

	for ($i=0; $i < $cnt; $i++) 
	{ 
		if ($xmlstruct->order[$i]['id'] == $ordernumber) 
		{
			switch ($xmlstruct->order[$i]['state']) 
			{
				case '0':
					$xmlstruct->order[$i]['state'] = '1';
					break;
				case '1':
					$xmlstruct->order[$i]['state'] = '2';
					$xmlstruct->order[$i]->addChild("description",$_POST['description']);
					$xmlstruct->order[$i]->addChild("problems",$_POST['problems']);
					break;
				case '2':
					$xmlstruct->order[$i]['state'] = '3';
					$xmlstruct->order[$i]->addChild("repairs",$_POST['repairs']);
					$xmlstruct->order[$i]->addChild("price",$_POST['price']);
					break;
				case '3':
					$xmlstruct->order[$i]['state'] = '4';
					break;
			}
			break;
		}
	}
	$xmlstruct->asXML('../order_list.xml');
}
function WriteInfoCancel()
{
	$xmlstruct = simplexml_load_file('../order_list.xml');
	$cnt = count($xmlstruct->order);
	$ordernumber = $_POST['CancelForm_request'];

	for ($i=0; $i < $cnt; $i++) 
	{ 
		if ($xmlstruct->order[$i]['id'] == $ordernumber) 
		{
			//$xmlstruct->order[$i]->comment = $ordercomment;
			//$xmlstruct->order[$cnt]->addChild("offdate",date('d-m-Y G:i'));
			$xmlstruct->order[$i]['state'] = '6';
			$xmlstruct->order[$i]->addChild("comment"," ");
			break;
		}
	}
	//echo $ordernumber." ".$xmlstruct->order[$cnt]['state']." ".$xmlstruct->order[$i]['id'];
	$xmlstruct->asXML('../order_list.xml');
}
function WriteInfoFinal()
{
	$xmlstruct = simplexml_load_file('../order_list.xml');
	$cnt = count($xmlstruct->order);
	$ordernumber = $_POST['FinalForm_request'];

	for ($i=0; $i < $cnt; $i++) 
	{ 
		if ($xmlstruct->order[$i]['id'] == $ordernumber) 
		{
			//$xmlstruct->order[$i]->comment = $ordercomment;
			$xmlstruct->order[$i]->addChild("offdate",date('d-m-Y G:i'));
			$xmlstruct->order[$i]->addChild("comment"," ");
			$xmlstruct->order[$i]['state'] = '5';
			break;
		}
	}
	//echo $ordernumber." ".$xmlstruct->order[$cnt]['state']." ".$xmlstruct->order[$i]['id'];
	$xmlstruct->asXML('../order_list.xml');
}
function GenerateActionForm()
{
	echo "<div id='ActionForm' class='invisible_form'>";
		echo "<form method='post' name='ActionForm'>";
			echo "Продолжить заявку № <div id='ActionForm_number'>0</div>?";
			echo "<div id='e1d'>Описание на приёме: <input type='text' id='description_txt' name='description'></div>";
			echo "<div id='e1pr'>Диагностика: <input type='text' id='problems_txt' name='problems'></div>";
			echo "<div id='e2r'>Работы: <input type='text' id='repairs_txt' name='repairs'></div>";
			echo "<div id='e2p'>Цена: <input type='text' id='price_txt' name='price'></div>";
			echo "<button id='ActionForm_request' name='ActionForm_request' type='submit' value='-1'>Подтвердить</button>";
		echo "</form>";
		echo "<input type='button' value='Отмена' onclick='ToggleActionForm(this,0)'>";
	echo "</div>";
}
function GenerateCancelForm()
{
	echo "<div id='CancelForm' class='invisible_form'>";
		echo "<form method='post' name='CancelForm'>";
			echo "Отменить заявку № <div id='CancelForm_number'>0</div>?";
			echo "<button id='CancelForm_request' name='CancelForm_request' type='submit' value='-1'>Отменить заявку</button>";
		echo "</form>";
		echo "<input type='button' value='Не отменять' onclick='ToggleCancelForm(this,0)'>";
	echo "</div>";
}
function GenerateFinalForm()
{
	echo "<div id='FinalForm' class='invisible_form'>";
		echo "<form method='post' name='FinalForm'>";
			echo "Завершить заявку № <div id='FinalForm_number'>0</div>?";
			echo "<button id='FinalForm_request' name='FinalForm_request' type='submit' value='-1'>Завершить заявку</button>";
		echo "</form>";
		echo "<input type='button' value='Отмена' onclick='ToggleFinalForm(this,0)'>";
	echo "</div>";
}	
?>