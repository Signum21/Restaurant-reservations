<?php
session_start();

$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

if(isset($_COOKIE[$randomValue]) && !isset($_SESSION[$datiProfilo])){		
	$dataNascita = "DATE_FORMAT(DataNascita, '%d/%m/%Y')";	
	$json_str = file_get_contents("env.json");
	$json = json_decode($json_str, true);
	$con = mysqli_connect($json['db_host'], $json['db_username'], $json['db_password'], $json['db_database'], $json['db_port']);	
	$sql = "SELECT Id, Nome, Cognome, $dataNascita AS 'Data di nascita', Genere, Tipo, Random, Username FROM Users 
			WHERE Random = '".$_COOKIE[$randomValue]."' AND Attivo = 1";
	
	$result = mysqli_query($con,$sql);	
	
	if(mysqli_num_rows($result) > 0){
		$_SESSION[$datiProfilo] = mysqli_fetch_assoc($result);
	}
	else { 
		setcookie($randomValue, 'Deleted', time()-(60*60*24*365));
		header("location: /index.php");
		die();
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Home</title>
<link rel="shortcut icon" href="Images/smallCutlery.png">
<link rel="stylesheet" type="text/css" href="Resources/css/styles.css">
<link rel="stylesheet" type="text/css" href="Resources/css/dropContentBody.css">
<link rel="stylesheet" type="text/css" href="Resources/css/header.css">
<script src="Resources/js/jquery-3.2.1.min.js"></script>
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
	<?php
	if(isset($_SESSION[$datiProfilo]) && $_SESSION[$datiProfilo]['Tipo'] === 'Cliente'){
 		print "<li class='dropdown'><a href='ricercaLocali.php' tabindex='-1'>Ricerca locali</a></li>";
	}
	?>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content">
        <?php
		if(!isset($_SESSION[$datiProfilo])){
			print "<ul id='ulReg'>
						<li class='side'><a href='login.php' tabindex='-1'>Entra</a></li>\n
						<li class='side'><a>Registrati</a>
							<div class='side-content'>\n
								<a href='registrazione.php?tipo=Cliente'>Cliente</a>\n
								<a href='registrazione.php?tipo=Proprietario'>Proprietario</a>
				 			</div>     				
						</li>
					</ul>\n";
		}
		else { 
			print "<a href='profilo.php' tabindex='-1'>Profilo</a>\n";
			
			if($_SESSION[$datiProfilo]['Tipo'] === 'Proprietario'){
				print "<a href='locali.php' tabindex='-1'>Locali</a>\n"; 
			}
			else { 
				print "<a href='elencoPrenotazioni.php' tabindex='-1'>Prenotazioni</a>"; 
			}
			print "<a href='logout.php' tabindex='-1'>Esci</a>\n"; 
		}
		?>
    	</div>
  	</li>
</ul><br/>

<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
	<tr><td colspan="2" align="center" style='padding: 10px'><h1>
		<?php
		if (isset($_SESSION[$datiProfilo])){
			print " Benvenuto ".$_SESSION[$datiProfilo]['Username']."! ";
		}
		else { 
			print " Benvenuto nel mio sito! "; 
		}
		?>
	</h1></td></tr>
	<tr><td align="center"><h3>
		<?php
		if (isset($_SESSION[$datiProfilo])){
			print "<a href='profilo.php' style='padding: 10px'><font color='1E42C1'>Profilo </font><img src='Images/profile.png'></a></h3></td>\n";
			
			if($_SESSION[$datiProfilo]['Tipo']==='Proprietario'){
				print "<td align='center'><h3><a href='locali.php' style='padding: 10px'><font color='1E42C1'>Locali </font><img src='Images/smallCutlery.png'></a></h3></tr>";
			}
			else{
				print "<td align='center'><h3><a href='ricercaLocali.php' style='padding: 10px'><font color='1E42C1'>Cerca locali </font><img src='Images/find.png'></a></h3></tr>";
			}
			print "<tr><td align='center' colspan='2'><h3><a href='logout.php' style='padding: 10px'><font color='1E42C1'>Esci </font><img src='Images/logout.png'></a></h3>\n";
		}
		else{
			print "<a href='login.php' style='padding: 27px'><font color='1E42C1'>Entra </font><img src='Images/login.png'></a></h3></td>\n";
			print "<td align='center'>
						<ul id='ulReg'>
							<li class='drop'><h3><a><font color='1E42C1'>Registrati </font><img src='Images/signin.png'></a></h3>\n
								<div class='drop-content' id='index'>
									<a href='registrazione.php?tipo=Cliente' tabindex='-1'>Cliente</a>\n
									<a href='registrazione.php?tipo=Proprietario' tabindex='-1'>Proprietario</a>\n
								</div>
							</li>
						</ul>\n"; 
		}
		?>
	</td></tr>
</table>
</body>
</html>