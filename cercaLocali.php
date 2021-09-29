<?php
if(!isset($_POST['filtro']) || !isset($_POST['tipo']))
{
	header("location: /index.php");
	die();
}
$filtro = $_POST['filtro'];
$tipo = $_POST['tipo'];

$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');
$sql= "SELECT Id, Nome, Foto1 FROM Locali WHERE $tipo = '$filtro' AND Attivo = 1";
$result = mysqli_query($con,$sql);

while($res = mysqli_fetch_array($result))
{
	echo $res['Id'].',';
	echo $res['Nome'].'_';
	echo $res['Foto1'].'.';
}
?>