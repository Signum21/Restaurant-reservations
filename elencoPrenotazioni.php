<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';
$data = "DATE_FORMAT(Prenotazioni.Data, '%d/%m/%Y')";	

$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');

if(isset($_SESSION[$datiProfilo])){
	if($_SESSION[$datiProfilo]['Tipo'] === 'Proprietario'){
		header("location: /index.php");
		die();
	}
	else{
		$sql = "SELECT Locali.Foto1, Locali.Nome, Prenotazioni.Id, $data AS Data, Prenotazioni.Stato FROM Prenotazioni INNER JOIN Locali
				ON Locali.Id = Prenotazioni.LocaleId WHERE Prenotazioni.UserId =".$_SESSION[$datiProfilo]['Id']." ORDER BY Data";
		
		$result = mysqli_query($con,$sql);
	}
}
else if(isset($_COOKIE[$randomValue]) && !isset($_SESSION[$datiProfilo])){
	$sql2 = "SELECT Id, Tipo FROM Users WHERE Random = '".$_COOKIE[$randomValue]."' AND Attivo = '1'";
	$result2 = mysqli_query($con,$sql2);
	
	if(mysqli_num_rows($result2) > 0){	
		$res2 = mysqli_fetch_assoc($result2);
	}
	else { 
		setcookie($randomValue, 'Deleted', time()-(60*60*24*365));
		header("location: /index.php"); 
		die();
	}
	
	if($res2['Tipo'] === 'Proprietario'){
		header("location: /index.php");
		die();
	}
	else{
		$sql = "SELECT Locali.Foto1, Locali.Nome, Prenotazioni.Id, $data AS Data, Prenotazioni.Stato FROM Prenotazioni INNER JOIN Locali
				ON Locali.Id = Prenotazioni.LocaleId WHERE Prenotazioni.UserId =".$_SESSION[$datiProfilo]['Id'];
		
		$result = mysqli_query($con,$sql);
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
<meta charset="utf-8">
<title>Prenotazioni</title>
<link rel="shortcut icon" href="Images/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Libraries/stili.css">
<link rel="stylesheet" type="text/css" href="Libraries/header.css">
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
	<li class='dropdown'><a href='ricercaLocali.php' tabindex='-1'>Ricerca locali</a></li>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content">
        	<a href='profilo.php' tabindex='-1'>Profilo</a>
			<a href='logout.php' tabindex='-1'>Esci</a> 
    	</div>
  	</li>
</ul><br/>

<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
	<tr>
		<td align="center" colspan="5" style="min-width: 300px"><h1>
			<img src="Images/prenotazione.png"> Prenotazioni
		</h1></td>
	</tr>
	
	<?php 
	if(mysqli_num_rows($result) > 0){
		while($res = mysqli_fetch_array($result)){
			print "<tr><td align='center'><img style='height: 60px; width: 90px; background-size: cover; padding: 5px;' ";

			if($res['Foto1'] === ''){
				print "src='Images/white.png'>";
			}
			else{
				print "src='data:image;base64,".$res['Foto1']."'>";
			}
			print "</td><td align='center' style='padding: 5px'>".$res['Nome']."</td>
					<td align='center' style='padding: 5px'>".$res['Data']."</td>
					<td align='center' style='padding: 5px'>".$res['Stato']."</td>
					<td align='center' style='padding: 5px'>
						<a href='datiPrenotazioneCliente.php?Id=".$res['Id']."'><font color='1E42C1'>Dettagli</font></a>
					</td></tr>";
		} 
	}
	else { 
		print '<tr><td align="center" style="padding: 5px" colspan="5">Nessuna prenotazione effettuata</td></tr>'; 
	}
	?>
</table>
</body>
</html>