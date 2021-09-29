var conta = 1000;

function aggiungiMenu(Id)
{
	"use strict";
	var Tipo = $('#tipo').val();
	var Nome = $('#nomePiatto').val();	
	var Prezzo = $('#prezzo').val();
	var Ingredienti = $('#ingredienti').val();	
	var Foto = document.getElementById('lab1').files;
	
	var formData = new FormData();
	formData.append('file[]', Foto[0]);
	
	var counter = 0;
	
	if(Tipo === 'Tipo')
	{
		$('#redTipo').css('background-color','red');
		counter++;
	}
	else { $('#redTipo').css('background-color','white'); }
	
	if(Nome.trim() === '')
	{
		$('#redNomePiatto').css('background-color','red');
		counter++;
	}
	else { $('#redNomePiatto').css('background-color','white'); }
	
	if(Prezzo.trim() === '')
	{
		$('#redPrezzo').css('background-color','red');
		counter++;
	}
	else { $('#redPrezzo').css('background-color','white'); }
	
	if(Ingredienti.trim() === '')
	{
		$('#redIngredienti').css('background-color','red');
		counter++;
	}
	else { $(redIngredienti).css('background-color','white'); }
	
	if(counter <= 0)
	{
		$.ajax(
		{ 
			type: "POST", url: 'Menu_Locale.php?Tipo='+Tipo+'&Nome='+Nome+'&Prezzo='+Prezzo+'&Ingredienti='+Ingredienti+'&LocaleId='+Id+'&Val='+'Aggiungi&counter='+conta, data: formData, 
			processData: false, contentType: false, cache: false, success: 
	
			function(response)
			{				
				if(response !== '0')
				{
					$('#addMenu').append(response);
					
					if($('#'+conta).attr('src') === 'data:image;base64,')
					{
						$('#'+conta).attr('src','Immagini/white.png');
					}			
					conta++;
					
					$('#menu')[0].reset();
					
					$('#redTipo').css('background-color','white');	
					$('#redNomePiatto').css('background-color','white');		
					$('#redPrezzo').css('background-color','white');	
					$('#redIngredienti').css('background-color','white');
					$('#redFoto').css('background-color','white');
					
					$('#dropzone1').css('background-image','url()');
					$('#dropzone1').attr('class','dropzone');
					$('#sign1').css('display','none');
				}
			}
		});
	}
}

function rimuovi(Id,Oggetto,Tabella)
{	
	"use strict";
	var richiesta = window.confirm("Sicuro di voler rimuovere il "+Oggetto+"?");
	
	if(richiesta === true)
	{
		$.ajax(
		{ 
			type: "POST", url: 'Menu_Locale.php?Val=Rimuovi', data: 'Id='+Id+'&Tabella='+Tabella, success: 
	
			function(response)
			{				
				if(response === '1')
				{
					$('#'+Id).remove();
				}
			}
		});		
	}
}