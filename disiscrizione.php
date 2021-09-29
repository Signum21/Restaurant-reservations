<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

if (!isset($_GET['dis']) || $_GET['dis'] !== $_SESSION[$datiProfilo]['Random']){
	header("location: /index.php");
	die();
}
$random = $_GET['dis'];

$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');
$sql = "UPDATE Users SET Attivo = 0 WHERE Random = '$random'"; 

if(mysqli_query($con,$sql)){
	if($_SESSION[$datiProfilo]['Tipo'] == 'Proprietario'){
		$sql4 = "SELECT Id FROM Locali WHERE UserId = ".$_SESSION[$datiProfilo]['Id'];
		$result = mysqli_query($con,$sql4);
		
		while($res = mysqli_fetch_assoc($result)){
			$sql2 = "UPDATE Locali SET Attivo = 0 WHERE Id = ".$res['Id'];
			$sql3 = "UPDATE Menu SET Attivo = 0 WHERE LocaleId = ".$res['Id'];

			mysqli_query($con,$sql2);
			mysqli_query($con,$sql3);
		}	
	}
	$successo = true;
	session_destroy();
	setcookie($randomValue, 'deleted', time()-(60*60*24*365));
}
else { 
	$successo = false; 
}
header("refresh:2; url=index.php");
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Esito disiscrizione</title>
<link rel="shortcut icon" href="Immagini/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Librerie/stili.css">
<link rel="stylesheet" type="text/css" href="Librerie/header.css">
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content">
        	<ul id="ulReg">
				<li class="side"><a href="login.php" tabindex='-1'>Entra</a></li>
				<li class="side"><a>Registrati</a>
					<div class="side-content">
				  		<a href="registrazione.php?tipo=Cliente">Cliente</a>
				  		<a href="registrazione.php?tipo=Proprietario">Proprietario</a>
				 	</div>     				
				</li>
			</ul>
    	</div>
  	</li>
</ul><br/>

<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
<tr><td align="center" style='padding: 10px'>
<?php
if($successo == true){
	print "<h1><img src='Immagini/ok.png'> Disiscrizione avvenuta con successo.</h1>\n";
	print "Verrai ora reindirizzato alla homepage...<br/>\n"; 
	print "Se il browser non reindirizza in automatico la pagina clicca <a href='index.php' tabindex='-1'><font color='1E42C1'>QUI</font></a>\n";	
}
else{
	print "<h1><img src='Immagini/error.png'> Disiscrizione fallita.</h1>\n";
	print "Verrai ora reindirizzato alla homepage...<br/>\n"; 
	print "Se il browser non reindirizza in automatico la pagina clicca <a href='index.php' tabindex='-1'><font color='1E42C1'>QUI</font></a>\n";
}
?>
</td></tr>
<tr>
   	<td align="center"><p><img src='Immagini/Loop.gif'></p></td>
</tr>
</table>
</body>
</html>