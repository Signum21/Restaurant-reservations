<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';
$data = "DATE_FORMAT(Data, '%d/%m/%Y')";
$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');

if(isset($_SESSION[$datiProfilo]))
{
	if($_SESSION[$datiProfilo]['Tipo'] === 'Proprietario')
	{
		header("location: /index.php");
		die();
	}	
	else if(isset($_GET['Id']))
	{
		$Id = $_GET['Id'];

		$sql = "SELECT UserId, LocaleId, $data AS 'Data', Ora, Persone, Stato FROM Prenotazioni WHERE Id = $Id";
		$result = mysqli_query($con,$sql);
		$res = mysqli_fetch_assoc($result);

		if($res['UserId'] == $_SESSION[$datiProfilo]['Id'])
		{
			$idLocale = $res['LocaleId'];
				
			$sql2 = "SELECT Nome,Numero,Citta,CAP,Indirizzo,NumeroCivico,Foto1,Foto2,Foto3,Foto4 FROM Locali WHERE Id = '$idLocale'";
			$result2 = mysqli_query($con,$sql2);
			$res2 = mysqli_fetch_assoc($result2);
	
			$sql3 = "SELECT MenuId, Quantita FROM menu_prenotazioni WHERE PrenotazioneId = '$Id'";
			$result3 = mysqli_query($con,$sql3);
			
			$arrayCounter = 0;
			$stringaPiatti = '';
			
			while($res3 = mysqli_fetch_assoc($result3))
			{
				$stringaPiatti = $stringaPiatti." Id = ".$res3['MenuId']." ||";
				
				$arrayQuantita[$arrayCounter] = $res3['Quantita'];
				$arrayCounter++;
			}
			$stringaPiatti = substr($stringaPiatti, 0, strlen($stringaPiatti)-2);
				
			$sql4 = "SELECT Tipo,Nome,Prezzo,Ingredienti,Foto FROM Menu WHERE $stringaPiatti";
			$result4 = mysqli_query($con,$sql4);
			
			$sql5 = "SELECT Prezzo FROM Menu WHERE $stringaPiatti";
			$result5 = mysqli_query($con,$sql5);
			
			$prezzo = 0;
			$arrayCounter = 0;
			
			while($res5 = mysqli_fetch_assoc($result5))
			{
				$prezzo = $prezzo + $res5['Prezzo']*$arrayQuantita[$arrayCounter];
				$arrayCounter++;
			}
		}
		else
		{
			header("location: /elencoPrenotazioni.php");
			die();
		}
	}
	else
	{
		header("location: /elencoPrenotazioni.php");
		die();
	}
}
else
{
	header("location: /index.php");
	die();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dati prenotazione</title>
<link rel="shortcut icon" href="Immagini/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Librerie/header.css">
<link rel="stylesheet" type="text/css" href="Librerie/stili.css">
<script src="Librerie/jquery-3.2.1.min.js"></script>
<script src="Librerie/viewLocale.js"></script>
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
	<li class='dropdown'><a href='ricercaLocali.php' tabindex='-1'>Ricerca locali</a></li>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content" style="z-index: 1">
        	<a href='profilo.php' tabindex='-1'>Profilo</a>
			<a href='logout.php' tabindex='-1'>Esci</a> 
    	</div>
  	</li>
</ul><br/>

<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
	<tr>
		<td align='center' colspan='2'>
<?php
print "<h1>".$res2['Nome']."</h1></td></tr>
		<tr><td colspan='2' align='center'><ul class='nav' onclick='navShow(4, ".'"dati"'.")'>Dati prenotazione<div id='dati' style='float: right'>-</div></ul></td></tr>
		<tr>
			<td width='540px' align='center' class='dati'>
				<div class='dati'>
					<table style='margin: 5px'>
						<tr>
							<td align='center' height='79px' width='300px' bgcolor='#f9f9f9'>Numero:</td>
							<td align='center' width='300px' bgcolor='#e0e0e0'>".$res2['Numero']."</td>
						</tr>
						<tr>
							<td align='center' height='79px' bgcolor='#e0e0e0'>Indirizzo:</td>
							<td align='center' bgcolor='#f9f9f9'>".$res2['Indirizzo']."</td>
						</tr>
						<tr>
							<td align='center' height='79px' bgcolor='#f9f9f9'>Numero civico:</td>
							<td align='center' bgcolor='#e0e0e0'>".$res2['NumeroCivico']."</td>
						</tr>
						<tr>
							<td align='center' height='79px' bgcolor='#e0e0e0'>Città:</td>
							<td align='center' bgcolor='#f9f9f9'>".$res2['Citta']."</td>
						</tr>
						<tr>
							<td align='center' height='79px' bgcolor='#f9f9f9'>CAP:</td>
							<td align='center' bgcolor='#e0e0e0'>".$res2['CAP']."</td>
						</tr>
					</table>
				</div>
			</td>
			<td align='center' class='dati' width='570px'>	
				<div class='dati'>
					<table style='margin: 5px'>
						<tr>
							<td align='center' height='79px' width='300px' bgcolor='#e0e0e0'>Data:</td>
							<td align='center' width='300px' bgcolor='#f9f9f9'>".$res['Data']."</td>
						</tr>
						<tr>
							<td align='center' height='79px' bgcolor='#f9f9f9'>Ora:</td>
							<td align='center' bgcolor='#e0e0e0'>".$res['Ora']."</td>
						</tr>
						<tr>
							<td align='center' height='79px' bgcolor='#e0e0e0'>Persone:</td>
							<td align='center' bgcolor='#f9f9f9'>".$res['Persone']."</td>
						</tr>
						<tr>
							<td align='center' height='79px' bgcolor='#f9f9f9'>Prezzo:</td>
							<td align='center' bgcolor='#e0e0e0'>€$prezzo</td>
						</tr>
						<tr>
							<td align='center' height='79px' bgcolor='#e0e0e0'>Stato prenotazione:</td>
							<td align='center' bgcolor='#f9f9f9'>".$res['Stato']."</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr><td colspan='2' align='center'><ul class='nav' onclick='navShow(2, ".'"menu"'.")'>Menù<div id='menu' style='float: right'>+</div></ul></td></tr>
		<tr>
			<td colspan='2' class='menu' style='visibility: hidden' align='center'>
				<div class='menu' style='display: none'>
					<table style='margin: 5px'>"; 					
		
	$bgcolor1 = '#f9f9f9';
	$bgcolor2 = '#e0e0e0';
	$arrayCounter = 0;
			
	while($res4 = mysqli_fetch_assoc($result4))
	{
		print "<tr class='".$res4['Tipo']."'>
				<td align='center' width='50px' bgcolor='$bgcolor1' style='padding: 5px'>".$arrayQuantita[$arrayCounter]."</td>
																			
				<td align='center' width='200px' bgcolor='$bgcolor2'>".$res4['Tipo']."</td>
				<td align='center' width='200px' bgcolor='$bgcolor1'>".$res4['Nome']."</td>
				<td align='center' width='100px' bgcolor='$bgcolor2'>€".$res4['Prezzo']."</td>
				<td align='center' style='word-break: break-all' width='415px' bgcolor='$bgcolor1'>".$res4['Ingredienti']."</td>
				<td align='center' bgcolor='$bgcolor2'><img style='height: 60px; width: 90px; background-size: cover; padding: 5px;' ";

		if($res4['Foto'] === '')
		{
			print "src='Immagini/white.png'>";
		}
		else
		{
			print "src='data:image;base64,".$res4['Foto']."'>";
		}
		$temp = $bgcolor1;
		$bgcolor1 = $bgcolor2;
		$bgcolor2 = $temp;
		
		$arrayCounter++;
	}
	?>   
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>
<br>

</body>
</html>