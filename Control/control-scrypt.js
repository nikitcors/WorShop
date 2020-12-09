function ToggleCommentForm(x)
{
	if (document.getElementById('comment').style.display == 'none') 
	{
		document.getElementById('order_number').innerText = x;
		document.getElementById('comment').style.display = 'inline';
	}
	else
	{
		document.getElementById('order_number').innerText = '0';
		document.getElementById('comment').style.display = 'none';
	}
}
function ToggleOrderForm()
{
	if (document.getElementById('order').style.display == 'none') 
	{
		document.getElementById('order').style.display = 'inline';
	}
	else
	{
		document.getElementById('order').style.display = 'none';
	}
}