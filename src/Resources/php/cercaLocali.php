<?php
if(!isset($_POST['filtro']) || !isset($_POST['tipo'])){
	header("location: /index.php");
	die();
}
$filtro = $_POST['filtro'];
$tipo = $_POST['tipo'];

$json_str = file_get_contents("../../env.json");
$json = json_decode($json_str, true);
$con = mysqli_connect($json['db_host'], $json['db_username'], $json['db_password'], $json['db_database'], $json['db_port']);
$sql = "SELECT Id, Nome, Foto1 FROM Locali WHERE $tipo = '$filtro' AND Attivo = 1";
$result = mysqli_query($con, $sql);

while($res = mysqli_fetch_array($result)){
	echo $res['Id'].',';
	echo $res['Nome'].'_';
	echo $res['Foto1'].'.';
}
?>