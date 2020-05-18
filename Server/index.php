<?php

    if(!session_id())
	{
		session_start();
		$_SESSION["isLoggedIn"] = false;
	}
	
    if (session_status() == PHP_SESSION_ACTIVE)
    {
        if($_SESSION["isLoggedIn"] == true)
        {
		    header("Location: files.php");
        }
	    else
	    {
		    header("Location: login.php");
		    	session_destroy();
	    }
    }
   
?>