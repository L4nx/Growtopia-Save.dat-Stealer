<?php

	session_start();

	if($_SESSION["isLoggedIn"]==true)
	{
		header("Location: files.php");
	}
	else
	{
		header("Location: login.php");
	}
    
?>