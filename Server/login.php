<?php

	session_start();

	if(isset($_POST["pass"]))
	{
		if($_POST["pass"] == "pakyubobo") // Ofc the password it is. Change "pakyubobo" (which is the default password) if want to.
		{	
			$includeHead = '<meta http-equiv="refresh" content="0; url=files.php" />';
			$_SESSION["isLoggedIn"]=true;
			include("header.php");
		} 
		else 
		{
			header("Location: error.php");
			session_destroy();
		}
	}

?>

<html>

    <head>
	
		<meta charset="utf-8">
		
		<title>Space Pirates</title>
		
		<style>
		
         .login-form {
         width: 300px;
         margin: 0 auto;
         font-family: Verdana, Geneva, sans-serif;
         }
         .login-form h1 {
         text-align: center;
         font-size: 60px;
         padding: 20px 0 0 0;
         font-family: "Arial Black", Gadget, sans-serif;
         }
         .login-form input[type="password"]
         {
         width: 300px;
         padding: 15px;
         border: 2px solid #ff3330;
         margin-bottom: 15px;
         box-sizing:border-box;
         background-color: #000000;
         color: #ffffff;
         font-size: 16px;
         font-weight: bold;
         font-family: Verdana, Geneva, sans-serif;
         }
         .login-form input[type="submit"] {
         width: 100px;
         padding: 16px;
         background-color: #000000;
         border: 2px solid #ff3330;
         cursor: pointer;
         font-weight: bold;
         color: #ffffff;
         font-family: Verdana, Geneva, sans-serif;
        }
		 
		</style>
		
	</head>
	
	<body bgcolor="#000000">
   
	<center>
   
      <br>
      <br>
	  
		<div class="wrapper">
	  
			<div class="login-form">
			
			<h1>
			
				<font color="#ff3330">SPACE</font>
				<font color="#ffffff">PIRATES</font>
			
            </h1>
          
            <form action="" method="post">
				<input type="password" name="pass" placeholder="Password">
				<input type="submit" value="LOGIN">
            </form>
			
			</div>
			
		</div>
		
	</center>
   
	</body>
	
</html>