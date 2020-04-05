<?php

	$file = $_GET["file"];

	$data = file_get_contents('files\\booties_data.json');

	$json_arr = json_decode($data, true);

	$arr_index = array();

	foreach ($json_arr as $key => $value)
	{
		if ($value['save'] == $file)
		{
			$arr_index[] = $key;
			unlink("files\\booties\\".$file.".txt");
		}
	}

	foreach ($arr_index as $i)
	{
		unset($json_arr[$i]);
	}

	$json_arr = array_values($json_arr);

	file_put_contents('files\\booties_data.json', json_encode($json_arr));

	header("Location: files.php");

?>