<?php
session_start();
$randomValue = 'r5f7ryVc3ye';
$datiProfilo = 'dh7aP7fj4ho';

if(isset($_SESSION[$datiProfilo]) || isset($_COOKIE[$randomValue])){
	header("location: /index.php");
	die();
}

if($_GET['tipo'] != 'Cliente' && $_GET['tipo'] != 'Proprietario'){
	header("location: /index.php");
	die();
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Registrazione</title>
<link rel="shortcut icon" href="Images/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Resources/css/stili.css">
<link rel="stylesheet" type="text/css" href="Resources/css/header.css">
<script src="Resources/js/jquery-3.2.1.min.js"></script>
<script src="Resources/js/funzioni.js"></script>
<script src="Resources/js/registrazioneCheck.js"></script>
</head>

<body>
<ul class="navigation-bar">
	<li class="dropdown"><a href="index.php" tabindex='-1'>Homepage</a></li>
  	<li class="dropdown"><a>Area riservata</a>
  		<div class="dropdown-content">
        	<a href='login.php' tabindex='-1'>Entra</a>
    	</div>
  	</li>
</ul><br/>

<form name="registrazione" action="esitoRegistrazione.php?tipo=<?php print $_GET['tipo']; ?>" method="post" onReset="return ConfermaReset(3)" onSubmit="return ControlloRegistrazione()">
<table align="center" border="5" bordercolor="1E42C1" bgcolor="white">
	<tr>
    	<td colspan="2" align="center">
        	<h1><img src="Images/registrati.png"> Registrazione</h1>
        </td>
    </tr>
    <tr>
    	<td style="padding: 5px">Nome:</td>
        <td><input title="Inserisci il tuo nome" placeholder="Nome" name="nome" required></td>
    </tr>
    <tr>
    	<td style="padding: 5px">Cognome:</td>
        <td><input title="Inserisci il tuo cognome" placeholder="Cognome" name="cognome" required></td>
    </tr>
    <tr>
    	<td style="padding: 5px">Data di nascita:</td>
        <td style="padding: 5px">
        	<select title="Seleziona il giorno" name="giorno">
            	<option>Giorno</option>
            	<?php
				for ($giorno=1; $giorno<=31; $giorno++){
					if(strlen((string)$giorno) == 1){
						print "<option>0$giorno</option>";
					}
					else{
						print "<option>$giorno</option>";
					}
				}
				?>
            </select>
        	<select title="Seleziona il mese" name="mese">
            	<option>Mese</option>
                <option value="01">Gen</option><option value="02">Feb</option><option value="03">Mar</option><option value="04">Apr</option>
				<option value="05">Mag</option><option value="06">Giu</option><option value="07">Lug</option><option value="08">Ago</option>
				<option value="09">Set</option><option value="10">Ott</option><option value="11">Nov</option><option value="12">Dic</option>
            </select>
            <select title="Seleziona l'anno" name="anno">
            	<option>Anno</option>
            	<?php
				for ($anno=date("Y")-18; $anno>=date("Y")-118; $anno--){
					print "<option>$anno</option>";
				}
				?>
            </select>
            <img src="Images/calendario.png" style="vertical-align: top">
        </td>
    </tr>
    <tr>
    	<td style="padding: 5px">Genere:</td>
    	<td align="center" style="padding: 5px">
        	<img src="Images/uomo.png" style="vertical-align: top"> Uomo <input type="radio" name="genere" value="Uomo" required> | 
            <input type="radio" name="genere" value="Donna" required> Donna <img src="Images/donna.png" style="vertical-align: top">
        </td>
    </tr>
    <tr><td colspan="2" height="15"></td></tr>
    <tr>
    	<td style="padding: 5px">Username:</td>
        <td>
        	<input title="Inserisci un username" placeholder="Username" id="username" name="username" onChange="ControlloUsername()" onKeyUp="ControlloUsername()" required> 
        	<span id="check_username"></span>
        </td>
    </tr>
    <tr>
    	<td style="padding: 5px">Password:</td>
        <td><input type="password" title="Inserisci una password" placeholder="Password" name="password" required></td>
    </tr>
    <tr>
    	<td style="padding: 5px">Conferma password: </td>
        <td><input type="password" title="Ripeti la password" placeholder="Conferma password" name="ripetiPassword" required></td>
    </tr>   
    <tr>
    	<td colspan="2" align="center">
        	<p><div id="check_empty"></div><div id="check_username2"></div><div id="check_password"></div></p>
        </td>
    </tr>     
    <tr>
        <td><button type="reset">Resetta</button></td>
    	<td><button type="submit">Invia</button></td>
    </tr>
    <tr>
		<td colspan="2" align="center"><p>Sei già registrato? <a href="login.php"><font color='1E42C1'>Entra</font></a></p></td>
    </tr>
</table>
</form>
<br>

</body>
</html>