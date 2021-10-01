<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');

if(isset($_SESSION[$datiProfilo]) && $_SESSION[$datiProfilo]['Tipo'] === 'Proprietario'){	
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
	
	if($res['Tipo'] === 'Proprietario'){
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
<title>Ricerca locali</title>
<link rel="shortcut icon" href="Images/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Libraries/stili.css">
<link rel="stylesheet" type="text/css" href="Libraries/header.css">
<script src="Libraries/jquery-3.2.1.min.js"></script>
<script src="Libraries/cercaLocali.js"></script>
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
	<li class='dropdown'><a href='ricercaLocali.php' tabindex='-1'>Ricerca locali</a></li>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content">
        	<a href='profilo.php' tabindex='-1'>Profilo</a>
			<a href='elencoPrenotazioni.php' tabindex='-1'>Prenotazioni</a>
			<a href='logout.php' tabindex='-1'>Esci</a> 
    	</div>
  	</li>
</ul><br/>

<form onSubmit="return false">
<table align="center" border="5" bordercolor="1E42C1" bgcolor="white" id="locali">
	<tr><td style="width: 500px" align="center" colspan="3"><h1>Cerca locali <img src='Images/lente.png'></h1></td></tr>
	<tr>
         <td align="center" style="width: 100px">
          	<select title="Seleziona il tipo di ricerca" id="tipo">
           		<option>Città</option><option>Nome</option>
        	</select>
		</td>
		<td><input title="Cerca locale" placeholder="Cerca locale" id='filtro'></td>
		<td style="width: 100px"><button onClick="cerca()">Cerca</button></td>
	</tr>
</table>
</form>
<br>

</body>
</html>