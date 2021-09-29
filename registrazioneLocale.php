<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');

if(isset($_SESSION[$datiProfilo]) && $_SESSION[$datiProfilo]['Tipo'] === 'Cliente'){
	header("location: /index.php");
	die();
}
else if(isset($_COOKIE[$randomValue]) && !isset($_SESSION[$datiProfilo])){
	$sql = "SELECT Tipo FROM Users WHERE Random = '".$_COOKIE[$randomValue]."' AND Attivo = '1'";
	$result = mysqli_query($con,$sql);
	
	if(mysqli_num_rows($result) > 0){
		$res = mysqli_fetch_assoc($result);
	}
	else { 
		setcookie($randomValue, 'Deleted', time()-(60*60*24*365));
		header("location: /index.php");
		die();
	}
	
	if($res['Tipo'] === 'Cliente'){
		header("location: /index.php");
		die();
	}
}
else if(!isset($_COOKIE[$randomValue]) && !isset($_SESSION[$datiProfilo])){
	header("location: /login.php");
	die();
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Registrazione locale</title>
<link rel="shortcut icon" href="Immagini/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Librerie/stili.css">
<link rel="stylesheet" type="text/css" href="Librerie/stileDrag.css">
<link rel="stylesheet" type="text/css" href="Librerie/header.css">
<script src="Librerie/jquery-3.2.1.min.js"></script>
<script src="Librerie/funzioni.js"></script>
<script src="Librerie/dragFoto.js"></script>
<script src="Librerie/registrazioneCheck.js"></script>
</head>

<body style="overflow-x: hidden">
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content">
       		<a href='profilo.php' tabindex='-1'>Profilo</a>
       		<a href='locali.php' tabindex='-1'>Locali</a>
        	<a href='logout.php' tabindex='-1'>Esci</a>
    	</div>
  	</li>
</ul><br/>

<form name="registrazioneLocale" action="esitoRegistrazioneLocale.php" method="post" onReset="return ConfermaReset(1)" onSubmit="return controlloRegistrazioneLocale()" enctype="multipart/form-data">
<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
	<tr>
    	<td colspan="2" align="center">
        	<h1><img src="Immagini/registrati.png"> Registrazione locale</h1>
        </td>
    </tr>
	<tr>
		<td style='padding: 10px'>Nome:</td>
		<td><input title="Inserisci il nome del locale" placeholder="Nome" name="nomeLocale" required></td>
	</tr>
	<tr>
		<td style='padding: 10px'>Numero:</td>
		<td><input title="Inserisci il numero" placeholder="Numero" name="numeroLocale" required></td>
	</tr>
	<tr>
		<td style='padding: 10px'>Città:</td>
		<td><input title="Inserisci la città" placeholder="Città" name="cittaLocale" required></td>
	</tr>
	<tr>
		<td style='padding: 10px'>CAP:</td>
		<td><input title="Inserisci il CAP" placeholder="CAP" name="CAP" required></td>
	</tr>
	<tr>
		<td style='padding: 10px'>Indirizzo:</td>
		<td><input title="Inserisci l'indirzzo" placeholder="Indirizzo" name="indirizzoLocale" required></td>
	</tr>
	<tr>
		<td style='padding: 10px'>Numero civico:</td>
		<td><input title="Inserisci il numero civico" placeholder="Numero civico" name="civicoLocale" required></td>
	</tr> 
    <tr>
		<td colspan="2"><p></p></td>
    </tr> 
    <tr>
		<td colspan="2">
			<input type="file" id="lab1" name="foto1" class="inputfile">
			<label for="lab1" id="dropzone1" class="dropzone" style="margin-left: 10px"><div class="cross" id="sign1"></div></label>
			
			<input type="file" id="lab2" name="foto2" class="inputfile">
			<label for="lab2" id="dropzone2" class="dropzone"><div class="cross" id="sign2"></div></label>
			
			<input type="file" id="lab3" name="foto3" class="inputfile">
			<label for="lab3" id="dropzone3" class="dropzone"><div class="cross" id="sign3"></div></label>
			
			<input type="file" id="lab4" name="foto4" class="inputfile">
			<label for="lab4" id="dropzone4" class="dropzone" style="margin-right: 10px"><div class="cross" id="sign4"></div></label>
		</td>
	</tr>
    <tr>
    	<td colspan="2" align="center">
        	<p><div id="check_empty_locale"></div><div id="checkType"></div></p>
        </td>
    </tr> 
    <tr>
        <td><button type="reset">Resetta</button></td>
    	<td><button type="submit">Invia</button></td>
    </tr>
</table>
</form>
<br>
</body>
</html>