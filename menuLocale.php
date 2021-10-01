<?php
$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');

if(isset($_GET['Val']) && $_GET['Val'] === 'Aggiungi'){
	if(!isset($_GET['LocaleId']) || !isset($_GET['Tipo']) || !isset($_GET['Nome']) || !isset($_GET['Prezzo']) || !isset($_GET['Ingredienti'])
	   || !isset($_GET['counter']))
	{
		header("location: /locali.php");
		die();
	}
	else
	{
		$LocaleId = $_GET['LocaleId'];
		$Tipo = $_GET['Tipo'];
		$Nome = $_GET['Nome'];
		$Prezzo = $_GET['Prezzo'];
		$Prezzo = str_replace(',','.',$Prezzo);
		$Ingredienti = $_GET['Ingredienti'];
		$counter = $_GET['counter'];
		$foto = '';
		
		if(isset($_FILES['file']['tmp_name'][0])){
			$foto = addslashes($_FILES['file']['tmp_name'][0]);
			$foto = file_get_contents($foto);
			$foto = base64_encode($foto);
		}

		$sql= "INSERT INTO Menu (LocaleId,Tipo,Nome,Prezzo,Ingredienti,Foto, Attivo) 
				VALUES ('$LocaleId','$Tipo','$Nome','$Prezzo','$Ingredienti','$foto', 1)";

		if(mysqli_query($con,$sql)){
			$sql2 = "SELECT Id,Tipo,Nome,Prezzo,Ingredienti,Foto FROM Menu WHERE LocaleId = '$LocaleId' ORDER BY Id DESC LIMIT 1";
			$result = mysqli_query($con,$sql2);	
			$res = mysqli_fetch_assoc($result);	

			$oggetto = '"menù"';
			$Tabella = '"Menu"';

			echo "<tr id='".$res['Id']."'><td align='center'>".$res['Tipo']."</td>
				<td align='center'>".$res['Nome']."</td><td align='center'>€".$res['Prezzo']."</td>
				<td align='center' width='300px' style='word-break: break-all;'>".$res['Ingredienti']."</td>
				<td align='center'><img id='$counter' style='height: 60px; width: 90px; background-size: cover; padding: 5px;' src='data:image;base64,".$res['Foto']."'></td>
				<td align='center'><a class='manina' onclick='rimuovi(".$res['Id'].", $oggetto, $Tabella)' tabindex='-1'><font color='1E42C1'>Rimuovi</font></a></td></tr>";
		}
		else { 
			echo '0'; 
		}	
	}
}
else if(isset($_GET['Val']) && $_GET['Val'] === 'Rimuovi'){
	if(!isset($_POST['Id']) || !isset($_POST['Tabella'])){
		header("location: /locali.php");
		die();
	}
	$Id = $_POST['Id'];
	$Tabella = $_POST['Tabella'];
	
	$sql = "UPDATE $Tabella SET Attivo = 0 WHERE Id = '$Id'";
	
	if(mysqli_query($con,$sql)){
		if ($Tabella == 'Locali'){
			$sql2 = "UPDATE Menu SET Attivo = 0 WHERE LocaleId = '$Id'";
			
			if(mysqli_query($con,$sql2)){
				echo '1';
			}
		}
		else { 
			echo '1'; 
		}
	}
	else { 
		echo '0'; 
	}
}
else { 
	header("location: /locali.php"); 
	die();
}
?>