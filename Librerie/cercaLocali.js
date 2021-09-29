var counter = 1;

function cerca(){	
	if(counter > 1){
		let elementi = $('.'+(counter-1));
	
		for(let b = 0; b < elementi.length; b++){
			elementi[b].remove();
		}
	}	
	let filtro = $('#filtro').val();
	let tipo = $('#tipo').val();	
	tipo = tipo.replace('à', 'a');
	
	$.ajax({
		url: 'cercaLocali.php', method: 'POST', data: 'filtro='+filtro+'&tipo='+tipo, success:
		
		function(response){
			if(response === ''){
				$('#locali').append('<tr class="'+counter+'"><td colspan="3" align="center"><p><font color="red"><img src="Immagini/error piccolo.png" style="vertical-align:top"> Nessun risultato</font></p></td></tr>');
			}
			else{
				let res = response.split('.');
			
				for(let a = 0; a < res.length-1; a++){
					let res2 = res[a].split(/[,_]+/);
					let img = (res2[2] !== '') ? 'data:image;base64,'+res2[2] : 'Immagini/white.png';
					$('#locali').append('<tr class="'+counter+'"><td colspan="2" align="center"><a href="visualizzaLocale.php?Id='+res2[0]+'"><font color="1E42C1">'+res2[1]+'</font></a></td><td align="center"><a href="visualizzaLocale.php?Id='+res2[0]+'"><img style="height: 60px; width: 90px; background-size: cover; padding: 5px;" src="'+img+'"></a></td></tr>');
				}
			}
			counter++;			
		}
	});
}