<?php
function GenerateForms()
{
	echo "<div class='invisible_container' id='invisible_container'>";
	GenerateCommentForm();
	GenerateOrderForm();
	echo "</div>";
}
function GenerateCommentForm()
{
	echo "<div id='comment' class='invisible_form'>";
		echo "<form method='post' name='comment'>";
			echo "Комментарий к заявке номер <div id='order_number'>0</div> : <input type='text' id='comment_text' name='comment'>";
			echo "<button id='comment_request' name='comment_request' type='submit' value='-1'>Отправить</button>";
		echo "</form>";
		echo "<input type='button' value='Отмена' onclick='ToggleCommentForm(this)'>";
	echo "</div>";
}
function GenerateOrderForm()
{
	echo "<div id='order' class='invisible_form'>";
		echo "<form method='post' name='order'>";
			echo "Создание заявки на ремонт";
			echo "<br>";
			echo "Техника: <input type='text' name='subject'>";
			echo "Описание проблемы: <input type='text' name='text'>";
			echo "<button name='order_request' type='submit' value='1'>Отправить</button>";
		echo "</form>";
		echo "<input type='button' value='Отмена' onclick='ToggleOrderForm()'>";
	echo "</div>";
}
function WriteComment()
{
	$xmlstruct = simplexml_load_file('../order_list.xml');
	$cnt = count($xmlstruct->order);
	$ordernumber = $_POST['comment_request'];
	$ordercomment = $_POST['comment'];
	for ($i=0; $i < $cnt; $i++) 
	{ 
		if ($xmlstruct->order[$i]['id'] == $ordernumber) 
		{
			$xmlstruct->order[$i]->comment = $ordercomment;
			break;
		}
	}
	$xmlstruct->asXML('../order_list.xml');
}
function WriteOrder()
{
	$xmlstruct = simplexml_load_file('../order_list.xml');
	$cnt = count($xmlstruct->order);
	$ordercnt = $cnt - 1;
	$xmlstruct->addChild("order");
	$xmlstruct->order[$cnt]->addAttribute("state",0);
	$xmlstruct->order[$cnt]->addAttribute("id",$cnt);
	$xmlstruct->order[$cnt]->addChild("date",date('d-m-Y G:i'));
	$xmlstruct->order[$cnt]->addChild("name",$_SESSION['nickname']);
	$xmlstruct->order[$cnt]->addChild("number",$_SESSION['login']);
	$xmlstruct->order[$cnt]->addChild("subject",$_POST['subject']);
	$xmlstruct->order[$cnt]->addChild("text",$_POST['text']);
	$xmlstruct->asXML('../order_list.xml');
}
?>