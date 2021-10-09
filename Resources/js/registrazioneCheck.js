var usernameAvailable;
var beforeResponse = 2;

function ControlloRegistrazione(){
	let i = 0;
	let nome = document.registrazione.nome.value;
	let cognome = document.registrazione.cognome.value;
	let giorno = document.registrazione.giorno.value;
	let mese = document.registrazione.mese.value;
	let anno = document.registrazione.anno.value;
	let username = document.registrazione.username.value;
	let password = document.registrazione.password.value;
	let ripetiPassword = document.registrazione.ripetiPassword.value;
	
	if(nome.trim() === '' || cognome.trim() === '' || username.trim() === '' || password.trim() === '' || ripetiPassword.trim() === '' || giorno === 'Giorno' || mese === 'Mese' || anno === 'Anno'){
		$("#check_empty").html('<font color="red"><img src="Images/warning piccolo.png" style="vertical-align:top"> Riempi tutti i campi.</font>');
		i++;
	}
	else { 
		$("#check_empty").html(''); 
	}
	
	if(usernameAvailable === false){
		$("#check_username2").html('<font color="red"><img src="Images/warning piccolo.png" style="vertical-align:top"> Username non disponibile.</font>');
		document.registrazione.username.focus();
		i++;
	}
	else { 
		$("#check_username2").html(''); 
	}
	
	if(password.trim() !== ripetiPassword.trim()){
		$("#check_password").html('<font color="red"><img src="Images/warning piccolo.png" style="vertical-align:top"> Le password inserite non coincidono.</font>');
		document.registrazione.ripetiPassword.value = "";
		document.registrazione.ripetiPassword.focus();
		i++;
	}
	else { 
		$("#check_password").html(''); 
	}
	return (i > 0) ? false : true;
}

function ControlloUsername(){
	let usernameValue = document.registrazione.username.value;
		
	if (usernameValue.trim() !== ''){
		$.ajax({ 
			type: "POST", url: "Resources/php/controlli.php?val=username", data: 'username='+usernameValue, success: 
	
			function(response){ 
				if(response !== beforeResponse){
					if(response === '0'){
						checkUsernameResult("ok piccolo.png", true, response);
					}
					else{
						checkUsernameResult("error piccolo.png", false, response);
					}
				}				
			}
		});
	}
	else{ 
		$("#username").css('width', '100%');
		$("#check_username").html('');
		beforeResponse = 2;
	}
}

function checkUsernameResult(image, available, response) {
	$("#username").css('width', '89%');
	$("#check_username").html('<img align="center" src="Images/' + image + '">');
	usernameAvailable = available;
	beforeResponse = response;
}

function controlloRegistrazioneLocale(){
	let nomeLocale = document.registrazioneLocale.nomeLocale.value;
	let numeroLocale = document.registrazioneLocale.numeroLocale.value;
	let cittaLocale = document.registrazioneLocale.cittaLocale.value;
	let CAP = document.registrazioneLocale.CAP.value;
	let indirizzoLocale = document.registrazioneLocale.indirizzoLocale.value;
	let civicoLocale = document.registrazioneLocale.civicoLocale.value;
	
	if(nomeLocale.trim() === '' || numeroLocale.trim() === '' || cittaLocale.trim() === '' || CAP.trim() === '' || indirizzoLocale.trim() === '' || civicoLocale.trim() === ''){
		$("#check_empty_locale").html('<font color="red"><img src="Images/warning piccolo.png" style="vertical-align:top"> Riempi tutti i campi.</font>');
		return false;
	}
}

function controlloPrenotazione(){
	let i = 0, e = 0;
	let giorno = document.prenotazione.giorno.value;
	let mese = document.prenotazione.mese.value;
	let anno = document.prenotazione.anno.value;
	let ora = document.prenotazione.ora.value;
	let minuto = document.prenotazione.minuto.value;
	let persone = document.prenotazione.persone.value;
	
	if(giorno === 'Giorno' || mese === 'Mese' || anno === 'Anno' || ora === 'Ora' ||  minuto === 'Minuto' ||  persone === 'Persone'){
		i++;
		$("#check_empty").html('<font color="red"><img src="Images/warning piccolo.png" style="vertical-align:top"> Riempi tutti i campi.</font>');
	}
	else { 
		$("#check_empty").html(''); 
	}	
	let menuCounter = $("[name^='menu']");
	
	for(let a = 0; a < menuCounter.length; a++){
		if(menuCounter[a].value > 0){
			e = 0;
			break;
		}
		else{ 
			e++; 
		}
	}
	
	if(e > 0){
		i++;
		$("#check_menu").html('<font color="red"><img src="Images/warning piccolo.png" style="vertical-align:top"> Seleziona almeno un piatto del menù.</font>');
	}
	else { 
		$("#check_menu").html(''); 
	}	
	controlloData(anno, mese, giorno);	
	return (i > 0) ? false : true;
}

function controlloPagamento(idUtente, idLocale, _menu){
	let i = 0;	
	let data = $("#data").html();
	let ora = $("#ora").html();
	let persone = $("#persone").html();
	
	let menu = _menu.split('_');
	let stringaMenu = '';
	let counter = 0;
	
	menu.forEach(
		function(oggetto){
			stringaMenu = stringaMenu + '&menu' + counter + '=' + oggetto;
			counter++;
		}
	);	
	let nome = document.pagamento.nome.value;
	let numero = document.pagamento.numero.value;
	let meseScadenza = document.pagamento.mese.value;
	let annoScadenza = document.pagamento.anno.value;
	let cvv = document.pagamento.cvv.value;
	
	if(nome.trim() === '' || numero.trim() === '' || meseScadenza === 'Mese' || annoScadenza === 'Anno' ||  cvv.trim() === ''){
		i++;
		$("#check_empty").html('<font color="red"><img src="Images/warning piccolo.png" style="vertical-align:top"> Riempi tutti i campi.</font>');
	}
	else { 
		$("#check_empty").html(''); 
	}
	controlloData(annoScadenza, meseScadenza);
	
	if(i <= 0){
		$('.modal').css('display','block');
		
		$.ajax({ 
			method: "POST", url: "Resources/php/esitoPrenotazione.php", 
			data: "idUtente="+idUtente+stringaMenu+"&idLocale="+idLocale+"&data="+data+"&ora="+ora+"&persone="+persone+"&nome="+nome+"&numero="+numero+
					"&meseScadenza="+meseScadenza+"&annoScadenza="+annoScadenza+"&cvv="+cvv, 
			success:
			
			function(response){
				if(response === '1'){
					$('#risultato').html('<h3><img src="Images/ok piccolo.png" style="vertical-align:top"> Richiesta di prenotazione avvenuta con successo </h3> Per essere valida la prenotazione dovrà essere accettata dal proprietario del locale <br> Clicca <a href="elencoPrenotazioni.php" tabindex="-1"><font color="1E42C1">qui</font></a> per verificare lo stato delle tue prenotazioni');					
				}
				else {
					$('#risultato').html('<h3><img src="Images/error piccolo.png" style="vertical-align:top"> Prenotazione fallita </h3> Clicca <a href="visualizzaLocale.php?Id='+idLocale+'" tabindex="-1"><font color="1E42C1">qui</font></a> per tornare alla pagina del locale'); 
				}
			}
		});
	}
	return false;
}

function controlloData(_anno, _mese, _giorno){
	let today = new Date();
	
	if(_anno !== 'Anno' && _anno == today.getFullYear()){
		if(_mese !== 'Mese' && _mese == today.getMonth()+1){
			if(_giorno !== 'Giorno' && _giorno <= today.getDate()){
				i++;
				$("#check_date").html('<font color="red"><img src="Images/warning piccolo.png" style="vertical-align:top"> La data deve essere nel futuro.</font>');
			}
			else { 
				$("#check_date").html(''); 
			}
		}
		else if(_mese !== 'Mese' && _mese < today.getMonth()+1){
			i++;
			$("#check_date").html('<font color="red"><img src="Images/warning piccolo.png" style="vertical-align:top"> La data deve essere nel futuro.</font>');
		}
		else { 
			$("#check_date").html(''); 
		}
	}
	else { 
		$("#check_date").html(''); 
	}
}