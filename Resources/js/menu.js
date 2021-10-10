var conta = 1000;

function aggiungiMenu(Id){
	let tipo = $('#tipo').val();
	let nome = $('#nomePiatto').val();	
	let prezzo = $('#prezzo').val();
	let ingredienti = $('#ingredienti').val();	
	let foto = document.getElementById('lab1').files;
	
	let formData = new FormData();
	formData.append('file[]', foto[0]);	

	let counter = 0;	
	counter += checkEmpty(tipo, "Tipo", "redTipo");
	counter += checkEmpty(nome, "", "redNomePiatto");
	counter += checkEmpty(prezzo, "", "redPrezzo");
	counter += checkEmpty(ingredienti, "", "redIngredienti");
	
	if(counter <= 0){
		$.ajax({ 
			type: "POST", url: 'Resources/php/menuLocale.php?Tipo='+tipo+'&Nome='+nome+'&Prezzo='+prezzo+'&Ingredienti='+ingredienti+'&LocaleId='+Id+'&Val='+'Aggiungi&counter='+conta, 
			data: formData, processData: false, contentType: false, cache: false, success: 	
			function(response){				
				addMenuResult(response);
			}
		});
	}
}

function checkEmpty(value, emptyValue, id){
	if(value.trim() === emptyValue){
		$('#' + id).css('background-color','red');
		return 1;
	}
	else { 
		$('#' + id).css('background-color','white'); 
		return 0;
	}
}

function addMenuResult(response){
	if(response !== '0'){
		$('#addMenu').append(response);
		
		if($('#'+conta).attr('src') === 'data:image;base64,'){
			$('#'+conta).attr('src','Resources/Images/white.png');
		}			
		conta++;
		$('#menu')[0].reset();										
		let redIds = ["redTipo", "redNomePiatto", "redPrezzo", "redIngredienti", "redFoto"]

		for(let rId of redIds){
			$('#' + rId).css('background-color','white');
		}					
		$('#dropzone1').css('background-image','url()');
		$('#dropzone1').attr('class','dropzone');
		$('#sign1').css('display','none');
	}
}

function rimuovi(Id,Oggetto,Tabella){
	let richiesta = window.confirm("Sicuro di voler rimuovere il "+Oggetto+"?");
	
	if(richiesta === true){
		$.ajax({ 
			type: "POST", url: 'Resources/php/menuLocale.php?Val=Rimuovi', data: 'Id='+Id+'&Tabella='+Tabella, success: 
	
			function(response){				
				if(response === '1'){
					$('#'+Id).remove();
				}
			}
		});		
	}
}