<?php
if (!isset($_POST['idUtente']) || !isset($_POST['idLocale']) || !isset($_POST['data']) || !isset($_POST['ora']) || !isset($_POST['persone']) || 
	!isset($_POST['nome']) || !isset($_POST['numero']) || !isset($_POST['meseScadenza']) || !isset($_POST['annoScadenza']) || !isset($_POST['cvv']))
{	
	header("location: /visualizzaLocale.php?Id=".$_POST['idLocale']);
	die();
}
$idUtente = $_POST['idUtente'];
$idLocale = $_POST['idLocale'];

$dataPrenotazione = $_POST['data'];
$dataArray = explode('/',$dataPrenotazione);
$dataPrenotazione = $dataArray[2].'-'.$dataArray[1].'-'.$dataArray[0];

$ora = $_POST['ora'];
$persone = $_POST['persone'];

/*             DATI CARTA

$nomeIntestatario = trim($_POST['nome']);

$numeroCarta = trim($_POST['numero']);
$numeroCarta = str_replace(' ','',$numeroCarta);

$dataScadenza = "28-".$_POST['meseScadenza']."-".$_POST['annoScadenza'];
$cvv = trim($_POST['cvv']);*/

$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');

$sql = "INSERT INTO Prenotazioni (UserId,LocaleId,Data,Ora,Persone,Stato) 
		VALUES ('$idUtente','$idLocale','$dataPrenotazione','$ora','$persone','Richiesta')";

if(mysqli_query($con,$sql)){
	$sql2 = "SELECT Id FROM Prenotazioni WHERE UserId = '$idUtente' AND LocaleId = '$idLocale' ORDER BY Id DESC LIMIT 1";
	$result = mysqli_query($con,$sql2);
	$res = mysqli_fetch_assoc($result);
	$prenotazioneId = $res['Id'];
	$i = 1;
	$beforeMenu = '';
	
	foreach($_POST as $key => $value){
		if(substr($key,0,4) != 'menu' && substr($key,0,4) != 'idUt'){
			break;
		}
		else if(substr($key,0,4) == 'menu'){
			if($value == $beforeMenu){
				$i++;
				$sql4 = "UPDATE menu_prenotazioni SET Quantita = '$i' WHERE PrenotazioneId = '$prenotazioneId' ORDER BY Id DESC LIMIT 1";
				mysqli_query($con,$sql4);
			}
			else{
				$i = 1;
				$sql3 = "INSERT INTO menu_prenotazioni (PrenotazioneId,MenuId,Quantita) VALUES ('$prenotazioneId','$value','$i')";
				mysqli_query($con,$sql3);
				$beforeMenu = $value;
			}
		}
	}
	echo '1';
}
else { 
	echo '0'; 
}
?>