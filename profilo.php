<?php
session_start();

$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');	
$dataNascita = "DATE_FORMAT(DataNascita, '%d/%m/%Y')";
$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

if (!isset($_SESSION[$datiProfilo]) && !isset($_COOKIE[$randomValue]) && isset($_POST['username'])){
	$username = $_POST['username'];
}

if (!isset($username) && !isset($_SESSION[$datiProfilo]) && !isset($_COOKIE[$randomValue])){
	header("location: /login.php");
	die();
}
else if(isset($username)){
	$sql5 = "SELECT Password FROM Users WHERE Username = '$username' AND Attivo ='1'";
	$result5 = mysqli_query($con,$sql5);
	
	if(mysqli_num_rows($result5) > 0){
		$res5 = mysqli_fetch_assoc($result5);
		
		if(!password_verify($_POST['password'], $res5['Password'])){
			header("location: /login.php");
			die();
		}
	}
	else { 
		header("location: /login.php"); 
		die();
	}
	
	if(isset($_POST['ricordami'])){
		do{
			$random = rand(1,999999999);
			$sql4 = "SELECT Nome FROM Users WHERE Random = '$random'";
			$result3 = mysqli_query($con,$sql4);
		}
		while(mysqli_num_rows($result3) > 0);
		
		$sql3 = "UPDATE Users SET Random = '$random' WHERE Username = '$username'";
		
		if(mysqli_query($con,$sql3)){
			setcookie($randomValue, $random, time()+(60*60*24*365));
		}
	}
	$sql = "SELECT Id, Nome, Cognome, $dataNascita AS 'Data di nascita', Genere, Tipo, Random, Username FROM Users 
			WHERE Username = '$username'";
	
	$result = mysqli_query($con,$sql);
	
	if(mysqli_num_rows($result) > 0){
		$array = mysqli_fetch_assoc($result);
		$_SESSION[$datiProfilo] = $array;
	}
	else { 
		header("location: /index.php"); 
		die();
	}
}
else if(isset($_COOKIE[$randomValue]) && !isset($_SESSION[$datiProfilo])){	
	$sql2 = "SELECT Id, Nome, Cognome, $dataNascita AS 'Data di nascita', Genere, Tipo, Random, Username FROM Users 
			WHERE Random = '".$_COOKIE[$randomValue]."' AND Attivo ='1'";
	
	$result2 = mysqli_query($con,$sql2);
	
	if(mysqli_num_rows($result2) > 0){
		$_SESSION[$datiProfilo] = mysqli_fetch_assoc($result2);
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
<title>Profilo</title>
<link rel="shortcut icon" href="Immagini/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Librerie/header.css">
<link rel="stylesheet" type="text/css" href="Librerie/stili.css">
<script src="Librerie/jquery-3.2.1.min.js"></script>
<script src="Librerie/funzioni.js"></script>
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
	<?php
	if($_SESSION[$datiProfilo]['Tipo'] === 'Cliente')
	{
 		print "<li class='dropdown'><a href='ricercaLocali.php' tabindex='-1'>Ricerca locali</a></li>";
	}
	?>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content">
       		<?php
			if($_SESSION[$datiProfilo]['Tipo']==='Proprietario')
			{
				print "<a href='locali.php' tabindex='-1'>Locali</a>";
			}
			else { print "<a href='elencoPrenotazioni.php' tabindex='-1'>Prenotazioni</a>"; }
			?>
        	<a href='logout.php' tabindex='-1'>Esci</a>
    	</div>
  	</li>
</ul><br/>

<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
<tr><td colspan='2' align='center'>
<?php
print "<h1><img src='Immagini/profilo.png'> Profilo ".$_SESSION[$datiProfilo]['Username']." <img src='Immagini/profilo.png'></h1></td></tr>\n";

foreach ($_SESSION[$datiProfilo] as $key => $value) { 
	if($key != 'Username' && $key != "Random" && $key != "Tipo" && $key != "Id"){
    	print "<tr><td style='padding: 5px'>$key:</td><td align='center' style='padding: 5px'>$value</td>\n</tr>\n";
	}
}
?>
<tr>
	<td colspan='2' align='center'>
    	<p>Non è il tuo account? <a href='logout.php'><font color='1E42C1'>Esci</font></a><br/>
        Vuoi disiscriverti? <a href="" onClick='Disiscrizione("<?php print $_SESSION[$datiProfilo]['Random']; ?>"); return false;'>
        <font color='1E42C1'>Disiscriviti</font></a></p>
	</td>
</tr>
</table>
</body>
</html>