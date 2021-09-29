<?php
$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');

if(isset($_GET['val']) && $_GET['val'] === 'menu'){
	if(isset($_POST['Id'])){
		$Id = $_POST['Id'];
	}
	else { 
		header("location: /locali.php"); 
		die();
	}
	
	$sql2 = "SELECT Stato FROM Prenotazioni WHERE Id = $Id";		
	$result2 = mysqli_query($con,$sql2);
	$res2 = mysqli_fetch_assoc($result2);
		
	$sql = "SELECT menu_prenotazioni.Quantita, Menu.Nome, Menu.Prezzo FROM menu_prenotazioni INNER JOIN Menu
			ON menu_prenotazioni.MenuId = Menu.Id WHERE menu_prenotazioni.PrenotazioneId = $Id";		
	$result = mysqli_query($con,$sql);

	if($result != false){
		$tot = 0;
		print "<table>
				<tr><td colspan='3' align='center'><b>Menù</b></td></tr>
				<tr><td colspan='3'><hr></td></tr>";

		while($res = mysqli_fetch_assoc($result)){
			print "<tr>
					<td>x ".$res['Quantita']."</td>
					<td align='center' style='padding: 5px'>".$res['Nome']."</td>
					<td align='center' style='padding: 5px'>".$res['Prezzo'].' €'."</td>
				   </tr>
				   <tr><td colspan='3'><hr></td></tr>";

			$prezzo = $res['Prezzo'] * $res['Quantita'];
			$tot = $tot + $prezzo;						
		}					
		print "<tr>
				<td align='center' colspan='2'><b>Totale</b></td>
				<td align='center'><b>$tot €</b></td>
			   </tr>";
			  
		if($res2['Stato'] == 'Richiesta'){
			print "<tr><td colspan='3' align='center'><p id='check_risposta'></p></td></tr>
				   <tr id='statoButtons'>
					<td colspan='3'>
					 <div style='float: left; width: 50%'><button onclick='statoPrenotazione(1, $Id)'>Accetta</button></div>
					 <div style='float: right; width: 50%'><button onclick='statoPrenotazione(0, $Id)'>Rifiuta</button></div>
					</td>
				   </tr>";
		}
		print "</table>";
	}
	else{
		print '0';
	}
}
else if(isset($_GET['val']) && $_GET['val'] === 'risposta'){
	if(isset($_POST['risposta']) && isset($_POST['Id'])){
		$risposta = $_POST['risposta'];
		$Id = $_POST['Id'];
	}
	else { 
		header("location: /locali.php"); 
		die();
	}	
	$sql3 = "UPDATE Prenotazioni SET Stato = '$risposta' WHERE Id = '$Id'";	
	
	if($result3 = mysqli_query($con,$sql3)){
		print '1';
	}
	else { print '0'; }
}
else { 
	header("location: /locali.php"); 
	die();
}
?>