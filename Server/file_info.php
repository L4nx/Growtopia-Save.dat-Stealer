<?php

    require("files\\verified.php");

    include("header.php");
    
	$array = explode("<=break=>", file_get_contents("files\\booties\\".$_GET["file"].".txt"));
	
    echo ("<table id='t01'><col width='1000'><tr><th>PC Info</th></tr>");
    echo "<tr><td style='padding-left:20px'><pre>";
	
    echo $array[1];
	
    echo "</td></tr></pre></table>";
	
?>