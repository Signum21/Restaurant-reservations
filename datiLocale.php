<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');

if(isset($_SESSION[$datiProfilo])){
	if($_SESSION[$datiProfilo]['Tipo'] === 'Cliente'){
		header("location: /index.php");
		die();
	}	
	else if(isset($_GET['Id'])){
		$Id = $_GET['Id'];
		
		$sql2 = "SELECT UserId FROM Locali WHERE Id = $Id AND Attivo = '1'";
		$result2 = mysqli_query($con,$sql2);
		$res2 = mysqli_fetch_assoc($result2);
		
		if($res2['UserId'] == $_SESSION[$datiProfilo]['Id']){
			$sql = "SELECT Nome,Numero,Citta,CAP,Indirizzo,NumeroCivico,Foto1,Foto2,Foto3,Foto4 FROM Locali WHERE Id = '$Id' AND Attivo = 1";
			$result = mysqli_query($con,$sql);
			$res = mysqli_fetch_assoc($result);
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
<meta charset="UTF-8">
<title>Dati locale</title>
<link rel="shortcut icon" href="Images/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Libraries/header.css">
<link rel="stylesheet" type="text/css" href="Libraries/stili.css">
<script src="Libraries/jquery-3.2.1.min.js"></script>
<script src="Libraries/slideFoto.js"></script>
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content" style="z-index: 1">
       		<a href='profilo.php' tabindex='-1'>Profilo</a>
       		<a href='locali.php' tabindex='-1'>Locali</a>
        	<a href='logout.php' tabindex='-1'>Esci</a>
    	</div>
  	</li>
</ul><br/>

<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
<?php
print "<tr><td colspan='3' align='center'><h1><img src='Images/posate.png'> Dati ".$res['Nome']." <img src='Images/posate.png'></h1></td></tr>
		<tr><td width='200px' align='center'>Nome:</td><td width='200px' align='center'>".$res['Nome']."</td>
		<td align='center' rowspan='6'>
			<div id='slide'><img style='height: 360px; width: 540px; background-size: cover; padding: 5px;' src='data:image;base64,".$res['Foto1']."'></div>
			<button onclick='cambiaFoto(".'"indietro"'.")' style='width: 270px; margin-bottom: 5px'><div class='navButton left'></div></button>
			<button onclick='cambiaFoto(".'"avanti"'.")' style='width: 270px'><div class='navButton right'></div></button><br>
		</td></tr>
		<tr><td align='center'>Numero:</td><td align='center'>".$res['Numero']."</td></tr>
		<tr><td align='center'>Indirizzo:</td><td align='center'>".$res['Indirizzo']."</td></tr>
		<tr><td align='center'>Numero civico:</td><td align='center'>".$res['NumeroCivico']."</td></tr>
		<tr><td align='center'>Città:</td><td align='center'>".$res['Citta']."</td></tr>
		<tr><td align='center'>CAP:</td><td align='center'>".$res['CAP']."</td></tr>";
?>
</table>
<script>
valori(<?php print '"'.$res['Foto1'].'","'.$res['Foto2'].'","'.$res['Foto3'].'","'.$res['Foto4'].'"' ?>);
</script>
</body>
</html>