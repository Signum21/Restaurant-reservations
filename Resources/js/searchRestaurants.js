var counter = 1;

$("#searchButton").on("click", function() {
	clearSearchResults();
	let filtro = $('#filtro').val();
	let tipo = $('#tipo').val();	
	tipo = tipo.replace('à', 'a');
	
	$.ajax({
		url: 'Resources/php/cercaLocali.php', method: 'POST', data: 'filtro='+filtro+'&tipo='+tipo, success: 
		function(response){
			displaySearchResult(response);
		}
	});
});

function clearSearchResults(params) {
	if(counter > 1){
		let elements = $('.'+(counter-1));

		for(let el of elements){
			el.remove();
		}
	}
}

function displaySearchResult(response){
	if(response === ''){
		$('#restaurants').append('<tr class="'+counter+'"><td colspan="3" align="center"><p><font color="red"><img src="Images/smallError.png" style="vertical-align:top"> Nessun risultato</font></p></td></tr>');
	}
	else{
		let res = response.split('.');
	
		for(let a = 0; a < res.length-1; a++){
			let res2 = res[a].split(/[,_]+/);
			let img = (res2[2] !== '') ? 'data:image;base64,'+res2[2] : 'Images/white.png';
			$('#restaurants').append('<tr class="'+counter+'"><td colspan="2" align="center"><a href="visualizzaLocale.php?Id='+res2[0]+'"><font color="1E42C1">'+res2[1]+'</font></a></td><td align="center"><a href="visualizzaLocale.php?Id='+res2[0]+'"><img style="height: 60px; width: 90px; background-size: cover; padding: 5px;" src="'+img+'"></a></td></tr>');
		}
	}
	counter++;			
}