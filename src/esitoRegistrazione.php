<?php
$tipo = $_GET['tipo'];

if (!isset($_POST['nome']) || !isset($_POST['cognome']) || !isset($_POST['giorno']) || !isset($_POST['mese']) || !isset($_POST['anno']) || 
	!isset($_POST['genere']) || !isset($_POST['username']) || !isset($_POST['password']) || !isset($_GET['tipo']))
{	
	header("location: /registrazione.php?tipo=$tipo");
	die();
}

$nome = trim($_POST['nome']);
$cognome = trim($_POST['cognome']);

$giorno = $_POST['giorno'];
$mese = $_POST['mese'];
$anno = $_POST['anno'];
$dataNascita = "$anno-$mese-$giorno";

$genere = $_POST['genere'];
$username = $_POST['username'];
$username = str_replace(' ','',$username);

$passwordClear = $_POST['password'];
$passwordClear = str_replace(' ','',$passwordClear);
$password = password_hash($passwordClear, PASSWORD_BCRYPT);

$json_str = file_get_contents("env.json");
$json = json_decode($json_str, true);
$con = mysqli_connect($json['db_host'], $json['db_username'], $json['db_password'], $json['db_database'], $json['db_port']);

do{
	$random = rand(1,999999999);
	$sql2 = "SELECT Nome FROM Users WHERE Random = '$random'";
	$result = mysqli_query($con,$sql2);
}
while(mysqli_num_rows($result) > 0);

$sql = "INSERT INTO Users (Nome,Cognome,DataNascita,Genere,Tipo,Random,Username,Password,Attivo) 
		VALUES ('$nome','$cognome','$dataNascita','$genere','$tipo','$random','$username','$password',1)";
$successo;

if(mysqli_query($con,$sql)){
	header("refresh:2; url=login.php");
	$successo = true;
}
else{ 
	header("refresh:2; url=registrazione.php?tipo=$tipo"); 
	$successo = false;
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Esito registrazione</title>
<link rel="shortcut icon" href="Resources/Images/smallCutlery.png">
<link rel="stylesheet" type="text/css" href="Resources/css/styles.css">
<link rel="stylesheet" type="text/css" href="Resources/css/header.css">
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
	print "<h1><img src='Resources/Images/ok.png'> Registrazione avvenuta con successo.</h1>\n";
	print "Verrai ora reindirizzato alla pagina di login...<br/>\n"; 
	print "Se il browser non reindirizza in automatico la pagina clicca <a href='login.php' tabindex='-1'><font color='1E42C1'>QUI</font></a>\n";	
}
else{
	print "<h1><img src='Resources/Images/error.png'> Registrazione fallita.</h1>\n";
	print "Verrai ora reindirizzato alla pagina di registrazione...<br/>\n"; 
	print "Se il browser non reindirizza in automatico la pagina clicca <a href='registrazione.php?tipo=$tipo' tabindex='-1'><font color='1E42C1'>QUI</font></a>\n";
}
?>
</td></tr>
<tr>
   	<td align="center"><p><img src='Resources/Images/loop.gif'></p></td>
</tr>
</table>
</body>
</html>