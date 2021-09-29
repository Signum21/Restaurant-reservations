<?php
if(isset($_FILES['file']['name'][0]))
{
	$allowed =  array('gif','png','jpg','jpeg','tif');
	$filename = $_FILES['file']['name'][0];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	
	$foto = addslashes($_FILES['file']['tmp_name'][0]);
	$foto = file_get_contents($foto);
	$foto = base64_encode($foto);
	
		
	foreach($_FILES['file']['name'] as $keys => $values)
	{
		if(in_array($ext,$allowed))
		{			
			$output = $foto;
		}
		else { $output = 'errorType'; }
	}
	echo $output;
}
else
{
	header("location: /index.php");
	die();
}
?>