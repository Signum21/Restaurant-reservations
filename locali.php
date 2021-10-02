<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

$json_str = file_get_contents("env.json");
$json = json_decode($json_str, true);
$con = mysqli_connect($json['db_host'], $json['db_username'], $json['db_password'], $json['db_database'], $json['db_port']);

if(isset($_SESSION[$datiProfilo])){
	if($_SESSION[$datiProfilo]['Tipo'] === 'Cliente'){
		header("location: /index.php");
		die();
	}	
	else{
		$sql4 = "SELECT Nome, Id, Foto1 FROM Locali WHERE UserId = '".$_SESSION[$datiProfilo]['Id']."' AND Attivo = '1'";
		$result3 = mysqli_query($con,$sql4);
	}
}
else if(isset($_COOKIE[$randomValue]) && !isset($_SESSION[$datiProfilo])){
	$sql = "SELECT Id, Tipo FROM Users WHERE Random = '".$_COOKIE[$randomValue]."' AND Attivo = '1'";
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
	else{
		$sql3 = "SELECT Nome, Id, Foto1 FROM Locali WHERE UserId = '".$res['Id']."' AND Attivo = '1'";
		$result3 = mysqli_query($con,$sql3);
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
<title>Locali</title>
<link rel="shortcut icon" href="Images/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Resources/css/stili.css">
<link rel="stylesheet" type="text/css" href="Resources/css/header.css">
<link rel="stylesheet" type="text/css" href="Resources/css/stileRegistrati.css">
<script src="Resources/js/jquery-3.2.1.min.js"></script>
<script src="Resources/js/menuLocale.js"></script>
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content">
       		<a href='profilo.php' tabindex='-1'>Profilo</a>
        	<a href='logout.php' tabindex='-1'>Esci</a>
    	</div>
  	</li>
</ul><br/>

<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
	<tr>
		<td align="center" style="min-width: 150px;  padding: 5px;" colspan="4"><h1>
			<img src="Images/posate.png" style="vertical-align: middle;"> Locali <img src="Images/posate.png">
		</h1></td>
	</tr>
	<tr>
		<td align="center" style="padding: 10px" colspan="4">
			<a href="registrazioneLocale.php"><font color='1E42C1'>Aggiungi</font></a>
		</td>
	</tr>
	<?php 
	while($res3 = mysqli_fetch_array($result3)){
		print "<tr id='".$res3['Id']."'><td align='center'><img style='height: 60px; width: 90px; background-size: cover; padding: 5px;' ";
		
		if($res3['Foto1'] === ''){
			print "src='Images/white.png'>";
		}
		else{
			print "src='data:image;base64,".$res3['Foto1']."'>";
		}
		print "</td><td align='center' style='padding: 5px'>".$res3['Nome']."</td><td align='center'>";
		
		print "<ul id='ulReg'>
				<li class='drop'><a><font color='1E42C1'>Gestisci</font></a>
  	  				<div class='drop-content' id='locali'>
        				<a href='datiLocale.php?Id=".$res3['Id']."' tabindex='-1'>Dati</a>
        				<a href='menu.php?Nome=".$res3['Nome']."&Id=".$res3['Id']."' tabindex='-1'>Menù</a>
        				<a href='prenotazioniLocale.php?Id=".$res3['Id']."' tabindex='-1'>Prenotazioni</a>
      				</div></li></ul>";
		
		print "</td><td align='center'><a class='manina' style='padding: 20px;' onclick='rimuovi(".$res3['Id'].",".'"locale"'.",".'"Locali"'.")'>
				<font color='1E42C1'>Rimuovi</font></a></td></tr>";
	} 
	?>
</table>
</body>
</html>