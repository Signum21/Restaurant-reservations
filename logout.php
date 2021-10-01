<?php
session_start();
$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

if (!isset($_SESSION[$datiProfilo]) && !isset($_COOKIE[$randomValue])){
	header("location: /login.php");
	die();
}
session_destroy();
setcookie($randomValue, 'Deleted', time()-(60*60*24*365));

header("refresh:2; url=login.php");
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Logout</title>
<link rel="shortcut icon" href="Images/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Libraries/stili.css">
<link rel="stylesheet" type="text/css" href="Libraries/header.css">
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
	<tr>
    	<td align="center">
        	<p><h1><img src='Images/ok.png'> Logout avvenuto con successo.</h1>
            Verrai ora reindirizzato alla pagina di login...<br/>
			Se il browser non reindirizza in automatico la pagina clicca <a href='login.php' tabindex='-1'><font color='1E42C1'>QUI</font></a></p>
		</td>
    </tr>
    <tr>
    	<td align="center"><p><img src='Images/Loop.gif'></p></td>
    </tr>
</table>
</body>
</html>