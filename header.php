<?php 
include "db.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<head>
	<title>Balders Nyheter</title>
	  <link rel="stylesheet" type="text/css"href="css/main.css">
	  <link rel="icon"  href="icon.png">
</head>
<body>
 	
 <header>
 	
 	<?php
 	if(isset($_SESSION["user_logged"]))
			{
				//echo "<p style=\"float: right;\">Inloggad som:", $_SESSION["user_logged"] ,"</p>";
			}
		?>
 	<h1 onclick="home()">Baldernyheter</h1>
 	<h4>Allt annat är fake news.</h4>
 	<?php
if(isset($_SESSION["user_logged"]))
	{
	echo "<p style=\"text-align: center;\">Inloggad som:\"", $_SESSION["user_logged"] ,"\".</p>";
	}
?>

 </header>
 <script>
 	function home()
 	{
 		location.replace("index.php");
 		}
 </script>
 <nav>

 	<a href="index.php">Hem</a>
 	<?php
		if(isset($_SESSION["user_logged"]))
		{
			if($_SESSION["user_logged"] == "admin")
			{
				echo "<a href=\"write.php\">Skriv inlägg</a>";
				echo "<a href=\"inbox.php\">Inbox</a>";
			}
			else
			{
				echo "<a href=\"tip.php\">Tipsa om nyheter.</a>";
			}
			echo "<a href=\"logout.php\">Logga ut.</a>";
		}
		else
		{
			echo "<a href=\"login.php\">Logga in</a>";
		}
 	?>
 </nav>
 <p style="text-align: center; width: 100%; color: gray;">BalderNyheter är ej associerat med Baldergymnasiet.</p>
 