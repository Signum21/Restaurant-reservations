var utenteTrovato = false;
var original = true;

function ConfermaReset(a)
{
	"use strict";
	var richiesta = window.confirm("Sicuro di voler reimpostare il modulo?");
	
	if(a === 1 && richiesta === true)
	{
		var labDrag = $('.dropzone');
		
		for(var b = 0; b<labDrag.length; b++)
		{
			labDrag[b].style.backgroundImage = 'url()';		
			labDrag[b].className = 'dropzone';
			
			var c = b + 1;
			$('#sign'+c).css('display','none');
		}
		$('#check_empty_locale').html('');
		$('#checkType').html('');
	}
	else if(a === 2 && richiesta === true)
	{		
		$('#check_login').html('');
	}
	else if(a === 3 && richiesta === true)
	{
		$('#check_empty').html('');
		$('#check_username2').html('');
		$('#check_password').html('');
		
		$("#check_username").html('');
		$("#username").css('width', '100%');
	}
	return richiesta;
}

function ControlloLogin()
{
	"use strict";
	
	if( original === true)
	{
		$("#check_login").html('<img src="Immagini/loading.gif" style="vertical-align:top"> Checking...');
		var usernameValue = document.login.username.value;
		var passwordValue = document.login.password.value;

		$.ajax
		({ 
			method: "POST", url: "controlli.php?val=login", data: 'username='+usernameValue+'&password='+passwordValue, success: 

			function(response)
			{ 
				if(response === '1')
				{
					original = false; 
					$( "#sub" ).submit();
				}
				else 
				{ 
					$("#check_login").html('<font color="red"><img src="Immagini/warning piccolo.png" style="vertical-align:top"> Username o password errati.</font>');
				}
			}
		});
		return false;
	}
}

function Disiscrizione(randomValue)
{
	"use strict";
	var richiesta = window.confirm("Sicuro di volerti disiscrivere?");
	
	if (richiesta === true)
	{
		location.href = 'disiscrizione.php?dis='+randomValue;
	}
}

function annullaPrenotazione(id)
{
	"use strict";
	var richiesta = window.confirm("Sicuro di voler annullare la prenotazione?");
	
	if (richiesta === true)
	{
		location.href = 'visualizzaLocale.php?Id='+id;
	}
}

function dettagliPrenotazione(id)
{
	"use strict";
	$(".modal").css("display","block");
	
	$.ajax
	({ 
		method: "POST", url: "dettagliPrenotazione.php?val=menu", data: 'Id='+id, success: 

		function(response)
		{ 
			if(response.substring(0,6) === '<table')
			{
				$('#risultato').html(response);					
			}
			else 
			{
				$('#risultato').html('<h3><img src="Immagini/error piccolo.png" style="vertical-align:top"> Caricamento fallito </h3>'); 
			}
		}
	});
}

function statoPrenotazione(_risposta, Id)
{
	'use strict';
	var risposta;
	
	if(_risposta == '1')
	{
		risposta = 'Accettata';
	}
	else { risposta = 'Rifiutata'; }
	
	$.ajax
	({ 
		method: "POST", url: "dettagliPrenotazione.php?val=risposta", data: 'risposta='+risposta+'&Id='+Id, success: 

		function(response)
		{ 
			if(response === '1')
			{
				
				$('#check_risposta').html('<img src="Immagini/ok piccolo.png" style="vertical-align:top"> '+risposta+'!'); 
				$("#"+Id).html(risposta);
				$("#statoButtons").css('display','none');
			}
			else 
			{
				$('#check_risposta').html('<img src="Immagini/error piccolo.png" style="vertical-align:top"> Caricamento fallito'); 
			}
		}
	});
}