function ToggleCommentForm(x)
{
	if (document.getElementById('comment').style.display == 'none' || document.getElementById('comment').style.display == '') 
	{
		document.getElementById('invisible_container').style.display = 'block';
		document.getElementById('order_number').innerText = x;
		document.getElementById('comment_request').value = x;
		document.getElementById('comment').style.display = 'inline';
		document.getElementById('comment_text').value = document.getElementById('cm-'+x).innerText;
	}
	else
	{
		document.getElementById('invisible_container').style.display = 'none';
		document.getElementById('comment_request').value = -1;
		document.getElementById('order_number').innerText = '0';
		document.getElementById('comment').style.display = 'none';
		document.getElementById('comment_text').innerText = '';
	}
}
function ToggleOrderForm()
{
	if (document.getElementById('order').style.display == 'none' || document.getElementById('order').style.display == '') 
	{
		document.getElementById('invisible_container').style.display = 'block';
		document.getElementById('order').style.display = 'inline';
	}
	else
	{document.getElementById('invisible_container').style.display = 'none';
		document.getElementById('order').style.display = 'none';
	}
}
function ToggleActionForm(x,state)
{
	if (document.getElementById('ActionForm').style.display == 'none' || document.getElementById('ActionForm').style.display == '') 
	{
		document.getElementById('invisible_container').style.display = 'block';
		document.getElementById('ActionForm_number').innerText = x;
		document.getElementById('ActionForm_request').value = x;
		document.getElementById('ActionForm').style.display = 'inline';
		//var stateorder = document.querySelector('#ord'+x).parentElement.id
		switch(state) 
		{
			case 1:  // if (x === 'value1')
		    	document.getElementById('e1d').style.display = 'block';
		    	document.getElementById('e1pr').style.display = 'block';
			break
			case 2:  // if (x === 'value2')
				document.getElementById('e2r').style.display = 'block';
		    	document.getElementById('e2p').style.display = 'block';
			break
		}
		//document.getElementById('ActionForm_text').value = document.getElementById('cm-'+x).innerText;
	}
	else
	{
		document.getElementById('e1d').style.display = 'none';
    	document.getElementById('e1pr').style.display = 'none';
    	document.getElementById('e2r').style.display = 'none';
    	document.getElementById('e2p').style.display = 'none';

		document.getElementById('invisible_container').style.display = 'none';
		document.getElementById('ActionForm_request').value = -1;
		document.getElementById('ActionForm_number').innerText = '0';
		document.getElementById('ActionForm').style.display = 'none';
		//document.getElementById('ActionForm_text').innerText = '';
	}
}
function ToggleCancelForm(x)
{
	if (document.getElementById('CancelForm').style.display == 'none' || document.getElementById('CancelForm').style.display == '') 
	{
		document.getElementById('invisible_container').style.display = 'block';
		document.getElementById('CancelForm_number').innerText = x;
		document.getElementById('CancelForm_request').value = x;
		document.getElementById('CancelForm').style.display = 'inline';
	}
	else
	{
		document.getElementById('invisible_container').style.display = 'none';
		document.getElementById('CancelForm_request').value = -1;
		document.getElementById('CancelForm_number').innerText = '0';
		document.getElementById('CancelForm').style.display = 'none';
		//document.getElementById('ActionForm_text').innerText = '';
	}
}
function ToggleFinalForm(x)
{
	if (document.getElementById('FinalForm').style.display == 'none' || document.getElementById('FinalForm').style.display == '') 
	{
		document.getElementById('invisible_container').style.display = 'block';
		document.getElementById('FinalForm_number').innerText = x;
		document.getElementById('FinalForm_request').value = x;
		document.getElementById('FinalForm').style.display = 'inline';
	}
	else
	{
		document.getElementById('invisible_container').style.display = 'none';
		document.getElementById('FinalForm_request').value = -1;
		document.getElementById('FinalForm_number').innerText = '0';
		document.getElementById('FinalForm').style.display = 'none';
		//document.getElementById('ActionForm_text').innerText = '';
	}
}
function RedirectHome()
{
	document.location.href = "http://localhost/WarpWorkshop/index.php";
}