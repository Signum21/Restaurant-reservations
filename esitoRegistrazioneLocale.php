<?php
session_start();

$datiProfilo = 'dh7aP7fj4ho';

if(!isset($_SESSION[$datiProfilo]) || !isset($_POST['nomeLocale']) || !isset($_POST['numeroLocale']) || !isset($_POST['cittaLocale'])
   || !isset($_POST['CAP']) || !isset($_POST['indirizzoLocale']) || !isset($_POST['civicoLocale']))
{
	header("location: /registrazioneLocale.php");
	die();
}
$UserId = $_SESSION[$datiProfilo]['Id'];
$nome = preg_replace('/[,_.]+/', ' ', $_POST['nomeLocale']);
$nome = trim($nome);
$numero = trim($_POST['numeroLocale']);
$citta = trim($_POST['cittaLocale']);
$cap = trim($_POST['CAP']);
$indirizzo = trim($_POST['indirizzoLocale']);
$civico = trim($_POST['civicoLocale']);
$foto1 = '';
$foto2 = '';
$foto3 = '';
$foto4 = '';

if($_FILES['foto1']['tmp_name'] != ''){
	$foto1 = addslashes($_FILES['foto1']['tmp_name']);
	$foto1 = file_get_contents($foto1);
	$foto1 = base64_encode($foto1);
}

if($_FILES['foto2']['tmp_name'] != ''){
	$foto2 = addslashes($_FILES['foto2']['tmp_name']);
	$foto2 = file_get_contents($foto2);
	$foto2 = base64_encode($foto2);
}

if($_FILES['foto3']['tmp_name'] != ''){
	$foto3 = addslashes($_FILES['foto3']['tmp_name']);
	$foto3 = file_get_contents($foto3);
	$foto3 = base64_encode($foto3);
}

if($_FILES['foto4']['tmp_name'] != ''){
	$foto4 = addslashes($_FILES['foto4']['tmp_name']);
	$foto4 = file_get_contents($foto4);
	$foto4 = base64_encode($foto4);
}
$json_str = file_get_contents("env.json");
$json = json_decode($json_str, true);
$con = mysqli_connect($json['db_host'], $json['db_username'], $json['db_password'], $json['db_database'], $json['db_port']);

$sql= "INSERT INTO Locali (UserId,Nome,Numero,Citta,CAP,Indirizzo,NumeroCivico,Foto1,Foto2,Foto3,Foto4,Attivo) 
		VALUES ('$UserId','$nome','$numero','$citta','$cap','$indirizzo','$civico','$foto1','$foto2','$foto3','$foto4',1)";
$successo;

if(mysqli_query($con,$sql)){
	header("refresh:2; url=locali.php");
	$successo = true;
}
else{ 
	header("refresh:2; url=registrazioneLocale.php"); 
	$successo = false;
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Esito registrazione locale</title>
<link rel="shortcut icon" href="Resources/Images/smallCutlery.png">
<link rel="stylesheet" type="text/css" href="Resources/css/styles.css">
<link rel="stylesheet" type="text/css" href="Resources/css/header.css">
</head>

<body>
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

<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
<tr><td align="center" style='padding: 10px'>
<?php
if($successo == true){
	print "<h1><img src='Resources/Images/ok.png'> Registrazione locale avvenuta con successo.</h1>";
	print "Verrai ora reindirizzato alla pagina di riepilogo dei locali...<br/>"; 
	print "Se il browser non reindirizza in automatico la pagina clicca <a href='locali.php' tabindex='-1'><font color='1E42C1'>QUI</font></a>";	
}
else{
	print "<h1><img src='Resources/Images/error.png'> Registrazione locale fallita.</h1>";
	print "Verrai ora reindirizzato alla pagina di registrazione del locale...<br/>"; 
	print "Se il browser non reindirizza in automatico la pagina clicca <a href='registrazioneLocale.php' tabindex='-1'><font color='1E42C1'>QUI</font></a>";
}
?>
</td></tr>
<tr>
   	<td align="center"><p><img src='Resources/Images/loop.gif'></p></td>
</tr>
</table>
</body>
</html>