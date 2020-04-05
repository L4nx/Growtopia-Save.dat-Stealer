<?php

	require("files\\verified.php");
	
	$array = explode("<=break=>", file_get_contents("files\\booties\\".$_GET["file"].".txt"));
	
	file_put_contents("save.dat", $array[0]);	

	header('Content-Type: application/download');
    header('Content-Disposition: attachment; filename="save.dat"');
    header("Content-Length: " . filesize("save.dat"));

    $fp = fopen("save.dat", "r");
    fpassthru($fp);
    fclose($fp);

	unlink ("save.dat");
	
	//header("Location: files.php");
	
?>