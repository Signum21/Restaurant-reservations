var usernameDisponibile;
var beforeResponse = 2;
var i = 0;

function ControlloRegistrazione()
{
	"use strict";
	i = 0;
	var nome = document.registrazione.nome.value;
	var cognome = document.registrazione.cognome.value;
	var giorno = document.registrazione.giorno.value;
	var mese = document.registrazione.mese.value;
	var anno = document.registrazione.anno.value;
	var username = document.registrazione.username.value;
	var password = document.registrazione.password.value;
	var ripetiPassword = document.registrazione.ripetiPassword.value;
	
	if(nome.trim() === '' || cognome.trim() === '' || username.trim() === '' || password.trim() === '' || ripetiPassword.trim() === '' || giorno === 'Giorno' || mese === 'Mese' || anno === 'Anno')
	{
		$("#check_empty").html('<font color="red"><img src="Immagini/warning piccolo.png" style="vertical-align:top"> Riempi tutti i campi.</font>');
		i++;
	}
	else { $("#check_empty").html(''); }
	
	if(usernameDisponibile === false)
	{
		$("#check_username2").html('<font color="red"><img src="Immagini/warning piccolo.png" style="vertical-align:top"> Username non disponibile.</font>');
		document.registrazione.username.focus();
		i++;
	}
	else { $("#check_username2").html(''); }
	
	if(password.trim() !== ripetiPassword.trim())
	{
		$("#check_password").html('<font color="red"><img src="Immagini/warning piccolo.png" style="vertical-align:top"> Le password inserite non coincidono.</font>');
		document.registrazione.ripetiPassword.value = "";
		document.registrazione.ripetiPassword.focus();
		i++;
	}
	else { $("#check_password").html(''); }
	
	return (i > 0) ? false : true;
}

function controlloRegistrazioneLocale()
{
	"use strict";
	var nomeLocale = document.registrazioneLocale.nomeLocale.value;
	var numeroLocale = document.registrazioneLocale.numeroLocale.value;
	var cittaLocale = document.registrazioneLocale.cittaLocale.value;
	var CAP = document.registrazioneLocale.CAP.value;
	var indirizzoLocale = document.registrazioneLocale.indirizzoLocale.value;
	var civicoLocale = document.registrazioneLocale.civicoLocale.value;
	
	if(nomeLocale.trim() === '' || numeroLocale.trim() === '' || cittaLocale.trim() === '' || CAP.trim() === '' || indirizzoLocale.trim() === '' || civicoLocale.trim() === '')
	{
		$("#check_empty_locale").html('<font color="red"><img src="Immagini/warning piccolo.png" style="vertical-align:top"> Riempi tutti i campi.</font>');
		return false;
	}
}

function ControlloUsername()
{
	"use strict";
	var usernameValue = document.registrazione.username.value;
		
	if (usernameValue.trim() !== '')
	{
		$.ajax(
		{ 
			type: "POST", url: "controlli.php?val=username", data: 'username='+usernameValue, success: 
	
			function(response)
			{ 
				if(response === '0' && response !== beforeResponse)
				{	
					$("#username").css('width', '89%');
					$("#check_username").html('<img align="center" src="Immagini/ok piccolo.png">');
					usernameDisponibile = true;
					beforeResponse = response;
				}
				else if(response === '1' && response !== beforeResponse)
				{
					$("#username").css('width', '89%');
					$("#check_username").html('<img align="center" src="Immagini/error piccolo.png">');
					usernameDisponibile = false;
					beforeResponse = response;
				}
			}
		});
	}
	else
	{ 
		$("#username").css('width', '100%');
		$("#check_username").html('');
		beforeResponse = 2;
	}
}

function controlloPrenotazione()
{
	'use strict';
	i=0;
	var e=0;
	var giorno = document.prenotazione.giorno.value;
	var mese = document.prenotazione.mese.value;
	var anno = document.prenotazione.anno.value;
	var ora = document.prenotazione.ora.value;
	var minuto = document.prenotazione.minuto.value;
	var persone = document.prenotazione.persone.value;
	
	if(giorno === 'Giorno' || mese === 'Mese' || anno === 'Anno' || ora === 'Ora' ||  minuto === 'Minuto' ||  persone === 'Persone')
	{
		i++;
		$("#check_empty").html('<font color="red"><img src="Immagini/warning piccolo.png" style="vertical-align:top"> Riempi tutti i campi.</font>');
	}
	else { $("#check_empty").html(''); }
	
	var menuCounter = $("[name^='menu']");
	
	for(var a=0; a<menuCounter.length; a++)
	{
		if(menuCounter[a].value > 0)
		{
			e=0;
			break;
		}
		else { e++; }
	}
	
	if(e>0)
	{
		i++;
		$("#check_menu").html('<font color="red"><img src="Immagini/warning piccolo.png" style="vertical-align:top"> Seleziona almeno un piatto del menù.</font>');
	}
	else { $("#check_menu").html(''); }
	
	controlloData(anno, mese, giorno);
	
	return (i > 0) ? false : true;
}

function controlloPagamento(idUtente, idLocale, _menu)
{
	'use strict';
	i = 0;
	
	var data = $("#data").html();
	var ora = $("#ora").html();
	var persone = $("#persone").html();
	
	var menu = _menu.split('_');
	var stringaMenu = '';
	var counter = 0;
	
	menu.forEach
	(
		function(oggetto)
		{
			stringaMenu = stringaMenu + '&menu' + counter + '=' + oggetto;
			counter++;
		}
	);
	
	var nome = document.pagamento.nome.value;
	var numero = document.pagamento.numero.value;
	var meseScadenza = document.pagamento.mese.value;
	var annoScadenza = document.pagamento.anno.value;
	var cvv = document.pagamento.cvv.value;
	
	if(nome.trim() === '' || numero.trim() === '' || meseScadenza === 'Mese' || annoScadenza === 'Anno' ||  cvv.trim() === '')
	{
		i++;
		$("#check_empty").html('<font color="red"><img src="Immagini/warning piccolo.png" style="vertical-align:top"> Riempi tutti i campi.</font>');
	}
	else { $("#check_empty").html(''); }
	
	controlloData(annoScadenza, meseScadenza);
	
	if(i <= 0)
	{
		$('.modal').css('display','block');
		
		$.ajax
		({ 
			method: "POST", url: "esitoPrenotazione.php", 
			data: "idUtente="+idUtente+stringaMenu+"&idLocale="+idLocale+"&data="+data+"&ora="+ora+"&persone="+persone+"&nome="+nome+"&numero="+numero+
					"&meseScadenza="+meseScadenza+"&annoScadenza="+annoScadenza+"&cvv="+cvv, 
			success:
			
			function(response)
			{
				if(response === '1')
				{
					$('#risultato').html('<h3><img src="Immagini/ok piccolo.png" style="vertical-align:top"> Richiesta di prenotazione avvenuta con successo </h3> Per essere valida la prenotazione dovrà essere accettata dal proprietario del locale <br> Clicca <a href="elencoPrenotazioni.php" tabindex="-1"><font color="1E42C1">qui</font></a> per verificare lo stato delle tue prenotazioni');					
				}
				else 
				{
					$('#risultato').html('<h3><img src="Immagini/error piccolo.png" style="vertical-align:top"> Prenotazione fallita </h3> Clicca <a href="visualizzaLocale.php?Id='+idLocale+'" tabindex="-1"><font color="1E42C1">qui</font></a> per tornare alla pagina del locale'); 
				}
			}
		});
	}
	return false;
}

function controlloData(_anno, _mese, _giorno)
{
	'use strict';
	var today = new Date();
	
	if(_anno !== 'Anno' && _anno == today.getFullYear())
	{
		if(_mese !== 'Mese' && _mese == today.getMonth()+1)
		{
			if(_giorno !== 'Giorno' && _giorno <= today.getDate())
			{
				i++;
				$("#check_date").html('<font color="red"><img src="Immagini/warning piccolo.png" style="vertical-align:top"> La data deve essere nel futuro.</font>');
			}
			else { $("#check_date").html(''); }
		}
		else if(_mese !== 'Mese' && _mese < today.getMonth()+1)
		{
			i++;
			$("#check_date").html('<font color="red"><img src="Immagini/warning piccolo.png" style="vertical-align:top"> La data deve essere nel futuro.</font>');
		}
		else { $("#check_date").html(''); }
	}
	else { $("#check_date").html(''); }
}