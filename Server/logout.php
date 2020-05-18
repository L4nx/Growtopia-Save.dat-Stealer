<?php

    $includeHead = '<meta http-equiv="refresh" content="0; url=login.php"/>';
    include("header.php");
    
    if(session_id())
	{
	    $_SESSION["isLoggedIn"]=false;
        session_destroy();
	}
	
?>