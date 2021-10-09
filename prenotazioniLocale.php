<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';
$data = "DATE_FORMAT(Data, '%d/%m/%Y')";	

$json_str = file_get_contents("env.json");
$json = json_decode($json_str, true);
$con = mysqli_connect($json['db_host'], $json['db_username'], $json['db_password'], $json['db_database'], $json['db_port']);

if(isset($_SESSION[$datiProfilo])){
	if($_SESSION[$datiProfilo]['Tipo'] === 'Cliente'){
		header("location: /index.php");
		die();
	}	
	else if(isset($_GET['Id'])){
		$Id = $_GET['Id'];
		
		$sql2 = "SELECT UserId, Nome FROM Locali WHERE Id = $Id AND Attivo = '1'";
		$result2 = mysqli_query($con,$sql2);
		$res2 = mysqli_fetch_assoc($result2);
		
		if($res2['UserId'] == $_SESSION[$datiProfilo]['Id']){
			$sql = "SELECT Id, $data AS Data, Ora, Persone, Stato FROM Prenotazioni WHERE LocaleId = $Id ORDER BY Prenotazioni.Data";		
			$result = mysqli_query($con,$sql);
		}
		else{
			header("location: /locali.php");
			die();
		}
	}
	else{
		header("location: /locali.php");
		die();
	}
}
else{
	header("location: /index.php");
	die();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Prenotazioni</title>
<link rel="shortcut icon" href="Images/smallCutlery.png">
<link rel="stylesheet" type="text/css" href="Resources/css/header.css">
<link rel="stylesheet" type="text/css" href="Resources/css/styles.css">
<link rel="stylesheet" type="text/css" href="Resources/css/modal.css">
<script src="Resources/js/jquery-3.2.1.min.js"></script>
<script src="Resources/js/functions.js"></script>
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

<div class="modal">
	<div class="modal-content" style="width: 300px">
		<span class="close" onclick='$(".modal").css("display","none");'>&times;</span>
		<div align="center" id="risultato"><img src="Images/loading.gif" style="vertical-align:top"> Caricamento in corso...</div>
	</div>
</div>

<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
	<tr>
		<td align="center" colspan="5" style="min-width: 300px"><h1>
			<img src="Images/reservation.png"> Prenotazioni <?php print $res2['Nome'] ?>
		</h1></td>
	</tr>
	
	<?php 
	if(mysqli_num_rows($result) > 0){
		while($res = mysqli_fetch_array($result)){
			print "</td><td align='center' style='padding: 5px'>".$res['Data']."</td>
					<td align='center' style='padding: 5px'>".$res['Ora']."</td>
					<td align='center' style='padding: 5px'>".$res['Persone']." Persone</td>
					<td align='center' style='padding: 5px' id='".$res['Id']."'>".$res['Stato']."</td>
					<td align='center' style='padding: 5px'>
						<a class='manina' onclick='dettagliPrenotazione(".$res['Id'].")'><font color='1E42C1'>Dettagli</font></a>
					</td></tr>";
		} 
	}
	else { 
		print '<tr><td align="center" style="padding: 5px" colspan="5">Nessuna prenotazione ricevuta</td></tr>'; 
	}
	?>
</table>
<br>

</body>
</html>