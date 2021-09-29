var counter = 1;

function cerca()
{
	"use strict";
	
	if(counter > 1)
	{
		var elementi = $('.'+(counter-1));
	
		for(var b = 0; b < elementi.length; b++)
		{
			elementi[b].remove();
		}
	}	
	var filtro = $('#filtro').val();
	var tipo = $('#tipo').val();
	
	if(tipo === 'Città')
	{
		tipo = 'Citta';
	}
	
	$.ajax
	({
		url: 'cercaLocali.php', method: 'POST', data: 'filtro='+filtro+'&tipo='+tipo, success:
		
		function(response)
		{
			if(response === '')
			{
				$('#locali').append('<tr class="'+counter+'"><td colspan="3" align="center"><p><font color="red"><img src="Immagini/error piccolo.png" style="vertical-align:top"> Nessun risultato</font></p></td></tr>');
			}
			else
			{
				var res = response.split('.');
			
				for(var a = 0; a < res.length-1; a++)
				{
					var res2 = res[a].split(/[,_]+/);
					var img; 

					if(res2[2] !== '')
					{
						img = 'data:image;base64,'+res2[2];
					}
					else
					{
						img = 'Immagini/white.png';
					}
					$('#locali').append('<tr class="'+counter+'"><td colspan="2" align="center"><a href="visualizzaLocale.php?Id='+res2[0]+'"><font color="1E42C1">'+res2[1]+'</font></a></td><td align="center"><a href="visualizzaLocale.php?Id='+res2[0]+'"><img style="height: 60px; width: 90px; background-size: cover; padding: 5px;" src="'+img+'"></a></td></tr>');
				}
			}
			counter++;			
		}
	});
}