<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');
$res = '';
$result2 = '';

function mostra()
{
	global $con;
	global $res;
	global $result2;
	
	if(isset($_GET['Id']))
	{
		$Id = $_GET['Id'];
	}
	$sql = "SELECT Nome, Numero, Citta, CAP, Indirizzo, NumeroCivico, Foto1, Foto2, Foto3, Foto4 FROM Locali WHERE Id = '$Id' AND Attivo = 1";
	
	$result = mysqli_query($con,$sql);

	if(mysqli_num_rows($result) > 0)
	{
		$res = mysqli_fetch_assoc($result);
	}
	else
	{
		header("location: /ricercaLocali.php");
		die();
	}

	$sql2 = "SELECT Id,Tipo,Nome,Prezzo,Ingredienti,Foto FROM Menu WHERE LocaleId = '$Id' AND Attivo = '1' ORDER BY case 
			when Tipo = 'Antipasto' then 1 when Tipo = 'Primo' then 2 when Tipo = 'Secondo' then 3 
			when Tipo = 'Dolce' then 4 when Tipo = 'Pizza' then 5 when Tipo = 'Panino' then 6 else 7 end asc";

	$result2 = mysqli_query($con,$sql2);
}

if(isset($_SESSION[$datiProfilo]))
{	
	if($_SESSION[$datiProfilo]['Tipo'] === 'Proprietario')
	{
		header("location: /index.php");
		die();
	}
	mostra();
}
else if(isset($_COOKIE[$randomValue]) && !isset($_SESSION[$datiProfilo]))
{
	$dataNascita = "DATE_FORMAT(DataNascita, '%d/%m/%Y')";
	$sql3 = "SELECT Id, Nome, Cognome, $dataNascita AS 'Data di nascita', Genere, Tipo, Random, Username FROM Users 
			WHERE Random = '".$_COOKIE[$randomValue]."' AND Attivo = 1";
	
	$result3 = mysqli_query($con,$sql3);
	
	if(mysqli_num_rows($result3) > 0)
	{	
		$_SESSION[$datiProfilo] = mysqli_fetch_assoc($result3);
	}
	else 
	{ 
		setcookie($randomValue, 'Deleted', time()-(60*60*24*365));
		header("location: /index.php");
		die();
	}
	
	if($_SESSION[$datiProfilo]['Tipo'] === 'Proprietario')
	{
		header("location: /index.php");
		die();
	}
	mostra();
}
else if(!isset($_COOKIE[$randomValue]) && !isset($_SESSION[$datiProfilo]))
{
	header("location: /login.php");
	die();
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php print $res['Nome']; ?></title>
<link rel="shortcut icon" href="Immagini/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Librerie/stili.css">
<link rel="stylesheet" type="text/css" href="Librerie/header.css">
<script src="Librerie/jquery-3.2.1.min.js"></script>
<script src="Librerie/viewLocale.js"></script>
<script src="Librerie/slideFoto.js"></script>
<script src="Librerie/registrazioneCheck.js"></script>
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

<form action="prenotazione.php?nome=<?php print $res['Nome'].'&id='.$_GET['Id']; ?>" method="post" onSubmit="return controlloPrenotazione()" name="prenotazione">
<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
	<?php
	print "<tr><td align='center' colspan='2'><h1>".$res['Nome']."</h1></td></tr>
			<tr><td colspan='2' align='center'><ul class='nav' onclick='navShow(4, ".'"dati"'.")'>Dati<div id='dati' style='float: right'>-</div></ul></td></tr>
			<tr>
				<td width='540px' align='center' class='dati'>
					<div class='dati'>
						<table style='margin: 5px'>
							<tr>
								<td align='center' height='79px' width='300px' bgcolor='#f9f9f9'>Numero:</td>
								<td align='center' width='300px' bgcolor='#e0e0e0'>".$res['Numero']."</td>
							</tr>
							<tr>
								<td align='center' height='79px' bgcolor='#e0e0e0'>Indirizzo:</td>
								<td align='center' bgcolor='#f9f9f9'>".$res['Indirizzo']."</td>
							</tr>
							<tr>
								<td align='center' height='79px' bgcolor='#f9f9f9'>Numero civico:</td>
								<td align='center' bgcolor='#e0e0e0'>".$res['NumeroCivico']."</td>
							</tr>
							<tr>
								<td align='center' height='79px' bgcolor='#e0e0e0'>Città:</td>
								<td align='center' bgcolor='#f9f9f9'>".$res['Citta']."</td>
							</tr>
							<tr>
								<td align='center' height='79px' bgcolor='#f9f9f9'>CAP:</td>
								<td align='center' bgcolor='#e0e0e0'>".$res['CAP']."</td>
							</tr>
						</table>
					</div>
				</td>
				<td align='center' class='dati' width='570px'>	
					<div class='dati'>
						<table style='margin: 5px'>
							<tr><td bgcolor='#f9f9f9' colspan='2' id='slide'><img style='height: 360px; width: 540px; background-size: cover; padding: 5px;' ";
	   
	if($res['Foto1'] === '')
	{
		print "src = 'Immagini/white.png'>";
	}
	else
	{
	   print "src='data:image;base64,".$res['Foto1']."'>";
	}
	print "					</td></tr>
							<tr><td><button type='button' onclick='cambiaFoto(".'"indietro"'.")'><div class='navButton left'></div></button></td>
							<td><button type='button' onclick='cambiaFoto(".'"avanti"'.")'><div class='navButton right'></div></button></td></tr>
						</table>
					</div>
				</td>
			</tr>
			<tr><td colspan='2' align='center'><ul class='nav' onclick='navShow(2, ".'"menu"'.")'>Menù<div id='menu' style='float: right'>+</div></ul></td></tr>
			<tr>
				<td colspan='2' class='menu' style='visibility: hidden' align='center'>
					<div class='menu' style='display: none'>"; 					
	
	if(mysqli_num_rows($result2) > 0)
	{
		print "<input type='checkbox' id='Antipasto' onclick='filtro(".'"Antipasto"'.")' 
				style='margin-top: 10px' checked>Antipasto
				<input type='checkbox' id='Primo' onclick='filtro(".'"Primo"'.")' checked>Primo
				<input type='checkbox' id='Secondo' onclick='filtro(".'"Secondo"'.")' checked>Secondo
				<input type='checkbox' id='Dolce' onclick='filtro(".'"Dolce"'.")' checked>Dolce
				<input type='checkbox' id='Pizza' onclick='filtro(".'"Pizza"'.")' checked>Pizza
				<input type='checkbox' id='Panino' onclick='filtro(".'"Panino"'.")' checked>Panino
				<input type='checkbox' id='Bibita' onclick='filtro(".'"Bibita"'.")' checked>Bibita
				
				<table style='margin: 5px'>";
		
		$bgcolor1 = '#f9f9f9';
		$bgcolor2 = '#e0e0e0';
		
		while($res2 = mysqli_fetch_array($result2))
		{
			print "<tr class='".$res2['Tipo']."'>
					<td align='center' width='50px' bgcolor='$bgcolor1' style='padding: 5px'><input type='number' min='0' name='menu".$res2['Id']."' value='0'></td>
																				
					<td align='center' width='200px' bgcolor='$bgcolor2'>".$res2['Tipo']."</td>
					<td align='center' width='200px' bgcolor='$bgcolor1'>".$res2['Nome']."</td>
					<td align='center' width='100px' bgcolor='$bgcolor2'>€".$res2['Prezzo']."</td>
					<td align='center' style='word-break: break-all' width='415px' bgcolor='$bgcolor1'>".$res2['Ingredienti']."</td>
					<td align='center' bgcolor='$bgcolor2'><img style='height: 60px; width: 90px; background-size: cover; padding: 5px;' ";

			if($res2['Foto'] === '')
			{
				print "src='Immagini/white.png'>";
			}
			else
			{
				print "src='data:image;base64,".$res2['Foto']."'>";
			}
			$temp = $bgcolor1;
			$bgcolor1 = $bgcolor2;
			$bgcolor2 = $temp;
		}
		print "</td></tr></table>";
	}
	else
	{
		print "<p>Menù non disponibile</p>";
	}
	print "</div></td></tr>";
	?>   
<tr><td colspan='2' align='center'><ul class='nav' onclick='navShow(2, "prenota")'>Prenotazione<div id='prenota' style='float: right'>+</div></ul></td></tr>
<tr>
	<td colspan='2' class='prenota' style='visibility: hidden' align='center'>
		<div class='prenota' style='display: none;'>
			<table style='margin: 5px'>
				<tr>
					<td style="padding: 5px" width='250px' align="center" bgcolor="#e0e0e0">
						<select title='Seleziona il giorno' style="margin-right: 15px" name='giorno'>
							<option>Giorno</option>
							<?php
							for ($giorno=1; $giorno<=31; $giorno++)
							{
								if(strlen((string)$giorno) == 1)
								{
									print "<option>0$giorno</option>";
								}
								else
								{
									print "<option>$giorno</option>";
								}
							}
							?>
						</select>
						<select title="Seleziona il mese" style="margin-right: 15px" name='mese'>
							<option>Mese</option>
							<option value="01">Gen</option><option value="02">Feb</option><option value="03">Mar</option><option value="04">Apr</option>
							<option value="05">Mag</option><option value="06">Giu</option><option value="07">Lug</option><option value="08">Ago</option>
							<option value="09">Set</option><option value="10">Ott</option><option value="11">Nov</option><option value="12">Dic</option>
						</select>
						<select title="Seleziona l'anno" name='anno'>
							<option>Anno</option>
							<?php
							for ($anno=date("Y"); $anno<=date("Y")+2; $anno++)
							{
								print "<option>$anno</option>";
							}							
							print '</select></td>
									<td style="padding: 5px" width="160px" align="center" bgcolor="#f9f9f9">
										<select title="Seleziona l'."'".'ora" style="margin-right: 15px" name="ora">
											<option>Ora</option>';
							
							for ($ora=0; $ora<=23; $ora++)
							{
								if(strlen((string)$ora) == 1)
								{
									print "<option>0$ora</option>";
								}
								else
								{
									print "<option>$ora</option>";
								}								
							}							
							print "</select>
									<select title='Seleziona il minuto' name='minuto'>
										<option>Minuto</option>";
							
							for ($minuto=0; $minuto<=59; $minuto++)
							{
								if(strlen((string)$minuto) == 1)
								{
									print "<option>0$minuto</option>";
								}
								else
								{
									print "<option>$minuto</option>";
								}								
							}
							print "</select></td>
									<td style='padding: 5px' width='100px' align='center' bgcolor='#e0e0e0'>
									<select name='persone'>
										<option>Persone</option>";
							
							for ($persone=1; $persone<=10; $persone++)
							{
								print "<option>$persone</option>";
							}
							?>
						</select>
					</td>
					<td width="200px"><button>Prenota</button></td>
				</tr>
				<tr><td colspan="4" align="center"><div id="check_empty"></div><div id="check_menu"></div><div id="check_date"></div></td></tr>
			</table>
		</div>
	</td>
</tr>
</table>
</form>
<br/>
	
<script>
valori(<?php print '"'.$res['Foto1'].'","'.$res['Foto2'].'","'.$res['Foto3'].'","'.$res['Foto4'].'"' ?>);
</script>

</body>
</html>