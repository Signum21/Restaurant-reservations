<?php
session_start();
$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

if (isset($_SESSION[$datiProfilo]) || isset($_COOKIE[$randomValue])){
	header("location: /index.php");
	die();
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="shortcut icon" href="Immagini/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Librerie/stili.css">
<link rel="stylesheet" type="text/css" href="Librerie/stileRegistrati.css">
<link rel="stylesheet" type="text/css" href="Librerie/header.css">
<script src="Librerie/jquery-3.2.1.min.js"></script>
<script src="Librerie/funzioni.js"></script>
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content">
        	<ul id="ulReg">
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

<form action="profilo.php" name="login" id="sub" method="post" onReset="return ConfermaReset(2)" onSubmit="return ControlloLogin()">
<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
	<tr>
    	<td colspan="2" align="center">
        	<h1><img src="Immagini/login.png"> Login</h1>
        </td>
	</tr>
	<tr>
		<td style="padding: 5px">Username:</td>
		<td align="center"><input title="Inserisci il tuo username" placeholder="Username" name="username" required></td>
	</tr>
	<tr>
		<td style="padding: 5px">Password:</td>
		<td align="center"><input type="password" title="Inserisci la tua password" placeholder="Password" name="password" required></td>
	</tr>   
    <tr>    	 	
    	<td colspan="2" align="center">
        	<p><input type="checkbox" name="ricordami">Ricordami</p>
        	<p id="check_login"></p>
        </td>
    </tr>
    <tr>
        <td><button type="reset">Resetta</button></td>
   		<td><button type="submit" class="input">Invia</button></td>
    </tr>
    <tr>
		<td colspan="2" align="center">
			<ul id="ulReg">
				<li class="drop" style="margin-left: 20px">Non sei ancora registrato?</li>
				<li class="drop"><a style='padding-left: 0px'><font color="1E42C1">Registrati</font></a>
  					<div class="drop-content">
        				<a href='registrazione.php?tipo=Cliente' tabindex='-1'>Cliente</a>
        				<a href='registrazione.php?tipo=Proprietario' tabindex='-1'>Proprietario</a>
    				</div>
    			</li>
   			</ul>
   		</td>
    </tr>
</table>
</form>
</body>
</html>