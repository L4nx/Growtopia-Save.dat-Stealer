<?php
   if(session_id())
    {
        
    }
    else
    {
         session_start();
    }
    
   if(!$_SESSION["isLoggedIn"])
   {
        header("Location: ../error.php");
        die();
   }
?>