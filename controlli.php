<?php
$con = mysqli_connect('localhost','root','','sitoRistoranti','3306');

if(isset($_GET['val']) && $_GET['val'] === 'login'){
	if(isset($_POST['username']) && isset($_POST['password'])){
		$username = $_POST['username'];
		$username = str_replace(' ','',$username);
		
		$passwordClear = $_POST['password'];
		$passwordClear = str_replace(' ','',$passwordClear);
	}
	else { 
		header("location: /login.php"); 
		die();
	}
	
	$sql = "SELECT Password FROM Users WHERE Username = '$username' AND Attivo = '1'";
	$result = mysqli_query($con,$sql);
	
	if(mysqli_num_rows($result) == 1){
		$res = mysqli_fetch_assoc($result);
		$hash = $res['Password'];

		if(password_verify($passwordClear, $hash)){
			echo '1';
		}
		else { echo '0'; }
	}
	else { echo '0'; }
}
else if(isset($_GET['val']) && $_GET['val'] === 'username'){
	if(isset($_POST['username'])){
		$username = $_POST['username'];
		$username = str_replace(' ','',$username);
	}
	else { 
		header("location: /index.php"); 
		die();
	}
	
	$sql2 = "SELECT Username FROM Users WHERE Username = '$username'";
	$result2 = mysqli_query($con,$sql2);

	echo (mysqli_num_rows($result2) > 0) ? '1' : '0';
}
else { 
	header("location: /login.php"); 
	die();
}
?>