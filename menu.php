<?php
session_start();

$datiProfilo = 'dh7aP7fj4ho';

$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');

if(isset($_SESSION[$datiProfilo]))
{
	if($_SESSION[$datiProfilo]['Tipo'] === 'Cliente')
	{
		header("location: /index.php");
		die();
	}	
	else if(isset($_GET['Nome']) && isset($_GET['Id']))
	{
		$NomeLocale = $_GET['Nome'];
		$LocaleId = $_GET['Id'];
		
		$sql2 = "SELECT UserId FROM Locali WHERE Id = $LocaleId";
		$result2 = mysqli_query($con,$sql2);
		$res2 = mysqli_fetch_assoc($result2);
		
		if($res2['UserId'] == $_SESSION[$datiProfilo]['Id'])
		{
			$sql = "SELECT Id,Tipo,Nome,Prezzo,Ingredienti,Foto FROM Menu WHERE LocaleId = '$LocaleId' AND Attivo = '1' ORDER BY case 
					when Tipo = 'Antipasto' then 1 when Tipo = 'Primo' then 2 when Tipo = 'Secondo' then 3 when Tipo = 'Dolce' then 4 
					when Tipo = 'Pizza' then 5 when Tipo = 'Panino' then 6 else 7 end asc";
			
			$result = mysqli_query($con,$sql);
		}
		else
		{
			header("location: /locali.php");
			die();
		}		
	}
	else
	{
		header("location: /locali.php");
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
<meta charset="UTF-8">
<title>Menù</title>
<link rel="shortcut icon" href="Immagini/posatePiccole.png">
<link rel="stylesheet" type="text/css" href="Librerie/stili.css">
<link rel="stylesheet" type="text/css" href="Librerie/stileDrag.css">
<link rel="stylesheet" type="text/css" href="Librerie/header.css">
<script src="Librerie/jquery-3.2.1.min.js"></script>
<script src="Librerie/dragFotoMenu.js"></script>
<script src="Librerie/menu_locale.js"></script>
</head>

<body style="overflow-x: hidden">
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

<form id="menu">
<table align="center" border="5" bordercolor="1E42C1" bgcolor="white" id="addMenu">
	<tr>
		<td align="center" colspan="6"><h1><img src="Immagini/posate.png" style="vertical-align: middle"> Menù <?php print $NomeLocale ?> <img src="Immagini/posate.png"></h1></td>
	</tr>
	<tr>
		<td id="redTipo">
			<select title="Seleziona il tipo di piatto" id="tipo" style="margin-left: 5px; margin-right: 5px;">
           		<option>Tipo</option>
            	<option>Antipasto</option><option>Primo</option><option>Secondo</option><option>Dolce</option><option>Pizza</option><option>Panino</option><option>Bibita</option>
        	</select>
		</td>
		<td id="redNomePiatto"><input title="Inserisci il nome del piatto" placeholder="Nome" id="nomePiatto" style="margin-left: 5px; margin-right: 5px; width: auto"></td>
		<td id="redPrezzo"><input title="Inserisci il prezzo del piatto" placeholder="Prezzo" id="prezzo" style="margin-left: 5px; margin-right: 5px; width: auto"></td>
		<td id="redIngredienti">
			<textarea rows="3" cols="50" title="Inserisci gli ingredienti del piatto" placeholder="Ingredienti" id="ingredienti" style="margin-left: 5px; margin-right: 5px; resize: none;"></textarea>
		</td>		
		<td id="redFoto">
			<input type="file" id="lab1" class="inputfile">
			<label for="lab1" id="dropzone1" class="dropzone" style="margin-left: 5px; margin-right: 5px;"><div class="cross" id="sign1"></div></label>
		</td>
		<td><a class="manina" onClick="aggiungiMenu(<?php print $LocaleId ?>)" style="margin-left: 5px; margin-right: 5px;"><font color='1E42C1'>Aggiungi</font></a></td>
	</tr>
	<?php
	$oggetto = '"menù"';
	$Tabella = '"Menu"';
			
	while($res = mysqli_fetch_array($result))
	{
		print "<tr id='".$res['Id']."'><td align='center'>".$res['Tipo']."</td><td align='center'>".$res['Nome']."</td><td align='center'>€".$res['Prezzo']."</td>
				<td align='center' style='word-break: break-all;' width='300px'>".$res['Ingredienti']."</td><td align='center'><img style='height: 60px; width: 90px; background-size: cover; padding: 5px;' ";
		
		if($res['Foto'] === '')
		{
			print "src='Immagini/white.png'>";
		}
		else
		{
			print "src='data:image;base64,".$res['Foto']."'>";
		}
		print "</td><td align='center'><a class='manina' onclick='rimuovi(".$res['Id'].",".'"menù"'.",".'"Menu"'.")'><font color='1E42C1'>Rimuovi</font></a></td></tr>";
	}
	?>
</table>
<br>
</form>
</body>
</html>