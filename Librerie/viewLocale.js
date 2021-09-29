function navShow(elementi, classe)
{
	'use strict';
	var navClass = document.getElementsByClassName(classe);
	
	if(navClass[0].style.visibility !== 'hidden')
	{
		for(var b=0; b<elementi; b+=2)
		{
			navClass[b].style.visibility = 'hidden';
			navClass[b+1].style.display = 'none';
		}
		$('#'+classe).html('+');
	}
	else
	{
		for(var c=0; c<elementi; c+=2)
		{
			navClass[c].style.visibility = 'visible';
			navClass[c+1].style.display = 'inline';
		}
		$('#'+classe).html('-');
	}
}

function filtro(_tipo)
{
	'use strict';
	var tipo = document.getElementById(_tipo);
	var tipoArr = document.getElementsByClassName(_tipo);
	
	if(tipo.checked === false)
	{		
		for(var a = 0; a<tipoArr.length; a++)
		{
			tipoArr[a].style.display = 'none';
		}
	}
	else
	{		
		for(var b = 0; b<tipoArr.length; b++)
		{
			tipoArr[b].style.display = '';
		}
	}
}