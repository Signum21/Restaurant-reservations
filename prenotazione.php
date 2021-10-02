<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

$json_str = file_get_contents("env.json");
$json = json_decode($json_str, true);
$con = mysqli_connect($json['db_host'], $json['db_username'], $json['db_password'], $json['db_database'], $json['db_port']);

if(isset($_SESSION[$datiProfilo]) && isset($_GET['nome']) && isset($_GET['id']) && isset($_POST['giorno']) && isset($_POST['mese']) && isset($_POST['anno'])
  	 && isset($_POST['ora']) && isset($_POST['minuto']) && isset($_POST['persone']))
{	
	if($_SESSION[$datiProfilo]['Tipo'] === 'Proprietario'){
		header("location: /index.php");
		die();
	}
	$queryString = '';

	foreach($_POST as $key => $value){
		if(substr($key,0,4) != 'menu'){
			break;
		}

		if($value > 0){
			$queryString = $queryString.' Id = '.substr($key, 4, strlen($key)-4).' || ';
		}
	}
	$sql = "SELECT Id, Nome, Prezzo FROM Menu WHERE".substr($queryString, 0, strlen($queryString)-4);
	$result = mysqli_query($con,$sql);

	if(mysqli_num_rows($result) <= 0){
		header("location: /ricercaLocali.php");
		die();
	}
}
else if(isset($_COOKIE[$randomValue]) && !isset($_SESSION[$datiProfilo])){
	$sql2 = "SELECT Tipo FROM Users WHERE Random = '".$_COOKIE[$randomValue]."' AND Attivo = '1'";
	$result2 = mysqli_query($con,$sql2);
	
	if(mysqli_num_rows($result2) > 0){	
		$res2 = mysqli_fetch_assoc($result2);
	}
	else { 
		setcookie($randomValue, 'Deleted', time()-(60*60*24*365));
		header("location: /index.php");
		die();
	}
	
	if($res2['Tipo'] === 'Proprietario' || !isset($_GET['id'])){
		header("location: /index.php");
		die();
	}
	else if(isset($_GET['id'])){
		$id = $_GET['id'];		
		header("location: /visualizzaLocale.php?Id=$id");
		die();
	}
}
else{
	header("location: /login.php");
	die();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Prenotazione</title>
<link rel="shortcut icon" href="Images/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Resources/css/stili.css">
<link rel="stylesheet" type="text/css" href="Resources/css/header.css">
<link rel="stylesheet" type="text/css" href="Resources/css/modal.css">
<script src="Resources/js/jquery-3.2.1.min.js"></script>
<script src="Resources/js/viewLocale.js"></script>
<script src="Resources/js/funzioni.js"></script>
<script src="Resources/js/registrazioneCheck.js"></script>
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
	<li class='dropdown'><a href='ricercaLocali.php' tabindex='-1'>Ricerca locali</a></li>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content" style="z-index: 1">
        	<a href='profilo.php' tabindex='-1'>Profilo</a>
			<a href='elencoPrenotazioni.php' tabindex='-1'>Prenotazioni</a>
			<a href='logout.php' tabindex='-1'>Esci</a> 
    	</div>
  	</li>
</ul><br/>

<div class="modal">
	<div class="modal-content">
		<span class="close" onclick='$(".modal").css("display","none");'>&times;</span>
		<p align="center" id="risultato"><img src="Images/loading.gif" style="vertical-align:top"> Richiesta di prenotazione in corso...</p>
	</div>
</div>
	
<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
	<tr><td align="center" colspan='2'><h1><img src="Images/prenotazione.png"> Prenotazione</h1></td></tr>
	<tr><td colspan='2' align='center'><ul class='nav' onclick='navShow(4, "dati")'>Dati<div id='dati' style='float: right'>-</div></ul></td></tr>
	<tr>
		<td align='center' class='dati' style='vertical-align: top;' width="626px">
			<div class='dati'>
				<table style="margin: 5px">
					<?php
					print '<tr>
								<td align="center" height="79px" width="300px" bgcolor="#f9f9f9">Locale: </td>
								<td align="center" width="300px" bgcolor="#e0e0e0">'.$_GET['nome'].'</td>
							</tr>
							<tr>
								<td align="center" height="79px" bgcolor="#e0e0e0">Data: </td>
								<td align="center" bgcolor="#f9f9f9" id="data">'.$_POST['giorno'].'/'.$_POST['mese'].'/'.$_POST['anno'].'</td>
							</tr>
							<tr>
								<td align="center" height="79px" bgcolor="#f9f9f9">Ora: </td>
								<td align="center" bgcolor="#e0e0e0" id="ora">'.$_POST['ora'].':'.$_POST['minuto'].'</td>
							</tr>
							<tr>
								<td align="center" height="79px" bgcolor="#e0e0e0">Persone: </td>
								<td align="center" bgcolor="#f9f9f9" id="persone">'.$_POST['persone'].'</td>
							</tr>';
					
					print "</table></div></td>
							<td align='center' class='dati' style='vertical-align: top' width='250px'>
								<div class='dati'>
									<table style='margin: 5px'>
										<tr><td colspan='3' align='center'><b>Menù</b></td></tr>
										<tr><td colspan='3'><hr></td></tr>";
					
					$tot = 0;
					$menu = ''; 
					
					while($res = mysqli_fetch_assoc($result))
					{
						print "<tr><td>x ".$_POST['menu'.$res['Id']]."</td><td align='center' style='padding: 5px'>".$res['Nome']."</td>
								<td align='center' style='padding: 5px'>".$res['Prezzo'].' €'."</td></tr><tr><td colspan='3'><hr></td></tr>";
						
						$prezzo = $res['Prezzo'] * $_POST['menu'.$res['Id']];
						$tot = $tot + $prezzo;
						
						for ($a = 0; $a < $_POST['menu'.$res['Id']]; $a++)
						{
							$menu = $menu.$res['Id'].'_';
						}						
					}
					$menu = substr($menu, 0, strlen($menu)-1);
					
					print "<tr><td align='center' colspan='2'><b>Totale</b></td><td align='center'><b>$tot €</b></td></tr>";
					?>
				</table>
			</div>
		</td>
	</tr>
	<tr><td colspan='2' align='center'><ul class='nav' onclick='navShow(2, "pagamento")'>Pagamento<div id='pagamento' style='float: right'>+</div></ul></td></tr>
	<tr>
		<td colspan="2" align="center" class="pagamento" style='visibility: hidden'>
			<div class="pagamento" style='display: none'>
				<form method="post" name="pagamento" onReset="return ConfermaReset()" 
					  onSubmit="return controlloPagamento(<?php print $_SESSION[$datiProfilo]['Id'].','.$_GET['id'].",'".$menu."'"; ?>)">
					
				<table border=2 style="margin: 5px" bordercolor="1E42C1">
					<tr>
						<td style="padding: 5px">Nome intestatario:</td>
						<td><input title="Inserisci il nome dell'intestatario della carta di credito" placeholder="Nome intestatario" name="nome" required></td>
					</tr>
					<tr>
						<td style="padding: 5px">Numero carta:</td>
						<td><input title="Inserisci il numero della carta di credito" placeholder="Numero carta" name="numero" required></td>
					</tr>
					<tr>
						<td style="padding: 5px">Data di scadenza:</td>
						<td align="center" style="padding: 5px">
							<select title="Seleziona il mese di scadenza" style="margin-right: 20px" name="mese">
								<option>Mese</option>
								<option value="01">Gen</option><option value="02">Feb</option><option value="03">Mar</option><option value="04">Apr</option>
								<option value="05">Mag</option><option value="06">Giu</option><option value="07">Lug</option><option value="08">Ago</option>
								<option value="09">Set</option><option value="10">Ott</option><option value="11">Nov</option><option value="12">Dic</option>
							</select>
							<select title="Seleziona l'anno di scadenza" name="anno">
								<option>Anno</option>
								<?php
								for ($anno=date("Y"); $anno<=date("Y")+50; $anno++)
								{
									print "<option>$anno</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="padding: 5px">CVV:</td>
						<td><input title="Inserisci CVV della carta di credito" placeholder="CVV" name="cvv" required></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><p><div id="check_empty"></div><div id="check_date"></div></p></td>
					</tr>
					<tr>
						<td colspan="2"><button type="button" onClick="annullaPrenotazione(<?php print $_GET['id']; ?>)">Annulla prenotazione</button></td>
					</tr>
					<tr>
						<td><button type="reset">Resetta</button></td>
						<td><button type="submit">Invia</button></td>
					</tr>
				</table>
				</form>
			</div>
		</td>
	</tr>
</table>
</br>

</body>
</html>