<?php

	if(!session_id())
	{
		session_start();
	}

?>

<!DOCTYPE html>

<html>

	<head>

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Space Pirates</title>

		<link rel="stylesheet" href="files/styles.css">

		<link rel="shortcut icon" href="files/skull.png">

<?php

	if(isset($includeHead))
	{
		echo($includeHead);
	}

?>

	</head>

	<body>

	<script>

		function myFunction()
		{
			var x = document.getElementById("navbar");

			if (x.className === "navigation")
			{
				x.className += " responsive";
			} 
			else
			{
				x.className = "navigation";
			}
		}

	</script>

	<div id="navbar" class="navigation">

<?php

	if(isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]==true)
	{

?>

		<a href="files.php"><div class="navit">Files</div></a>

		<a href="logout.php"><div class="navit">Log out</div></a>

<?php

	}

?>

	</div>

	<div class="main">