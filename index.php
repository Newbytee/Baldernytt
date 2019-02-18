<!doctype html>
	<?php
		include "header.php";
	?>
	<main>
		<?php
		if(isset($_SESSION["user_logged"]))
		{
			if($_SESSION["user_logged"] == "admin")
			{
				echo"<article>
				<form method=\"POST\">
				<input type=\"text\" name=\"artic\"><input type=\"submit\" name=\"sql_go\" value=\"Skriv ID på post att ta bort\">
				<br><br>
				<input type=\"text\" name=\"comm\"><input type=\"submit\" name=\"sql_com\" value=\"Skriv ID på kommentar att ta bort\">
				</form>
				</article>";
				if(isset($_POST["sql_go"]))
				{
					$ID_TR = htmlspecialchars($_POST["artic"]);
					$sql = "DELETE FROM `inlagg` WHERE ID = \"$ID_TR\"";
					if(mysqli_query($conn, $sql))
					{
						echo "<article><h4 style=\"color: green;\">Tog bort inlägg.</h4></article>";
					}
					else
					{
						echo "<article><h4 style=\"color: red;\">Kunde ej ta bort inlägg.</h4></article>";
					}
				}
				else if(isset($_POST["sql_com"]))
				{
					$ID_TR = htmlspecialchars($_POST["comm"]);
					$sql = "DELETE FROM `comment` WHERE ID = \"$ID_TR\"";
					if(mysqli_query($conn, $sql))
					{
						echo "<article><h4 style=\"color: green;\">Tog bort Kommentar.</h4></article>";
					}
					else
					{
						echo "<article><h4 style=\"color: red;\">Kunde ej ta bort Kommentar.</h4></article>";
					}
				}
			}
		}
		$sql = "SELECT * FROM `comment` WHERE 1=1 ORDER BY ID ASC";
		$comList = array();
		if ($result = mysqli_query($conn,$sql)) 
		{
		 while($row = mysqli_fetch_object($result))
			    {
			    	$Com = new Comment();
			    	//$Com = new Comment($row[0], $row[1], $row[2], $row[3]);
			    	$Com->ID = $row->ID;
			        $Com->comtext = $row->comtext;
			        $Com->comOn = $row->comon;
			        $Com->sender = $row->sender;
			        array_push($comList, $Com);
			    }
				
			}
		//echo Count($comList);
			if(strlen($_SERVER["QUERY_STRING"]) > 0)
			{
				$querID = $_SERVER["QUERY_STRING"];
				$sql = "SELECT * FROM `inlagg` WHERE id = $querID;";
			}
			else
			{
				$sql = "SELECT * FROM `inlagg` WHERE 1=1 ORDER BY id DESC";
			}
			if ($result = mysqli_query($conn,$sql)) 
			{
			     while($row = mysqli_fetch_row($result))
			    {
			    	$ID[] = $row[0];
			        $bild[]  = $row[1];
			        $content[] = $row[2];
			        $date[] = $row[3];
			    }
			    if(Count($content) < 1)
			    {
			    	header("Location: index.php");
			    }
			    for ($i=0; $i < Count($content); $i++) 
			    { 
		    	if(strlen($_SERVER["QUERY_STRING"]) > 0)
				{
			    	if(strlen($bild[$i]) > 6)
			    	{
			    		echo"<article><img src=\"$bild[$i]\" alt=\"bild\"></img>", $content[$i], "<span>", $date[$i], "</span>";
			    	}
			    	else
			    	{
			    		echo"<article>", $content[$i], "<span>", $date[$i], "</span>";
			    	}
						$combox = "combox" . $i;
						$submit = "submit" . $i;
						$comid =  $ID[$i];
						//SKRIV UT KOMMENTARER UNDER DIV
						//$sql = "SELECT * FROM `comment` WHERE `comon` = \"$comid\";";
						//$sql = "SELECT * FROM `comment` WHERE 1=1 ORDER BY ID DESC;";
						echo "<br><br><h3>Kommentarer</h3><div>";
						foreach ($comList as $comment)
						{
							/*var_dump($comment->comOn);
							echo "<br>";
							var_dump($comment->comtext);
							echo "<br>";
							echo "<br>";*/
							if($comment->comOn == $ID[$i] ||$comment->comOn == 0)
							{
								echo "<div class=\"comment\"><b>$comment->sender</b><p>$comment->comtext</p>";
								if(isset($_SESSION["user_logged"]))
								{
									if($_SESSION["user_logged"] == "admin")
									{
										echo"<span>ID: $comment->ID</span></div>";
									}
									else
									{
										echo"</div>";
									}
								}
								else
								{
									echo"</div>";
								}
							}
						}
						if(isset($_SESSION["user_logged"]))
							{
								echo "</div><form class=\"combox\" method=\"POST\"><textarea name=\"$combox\" placeholder=\"Kommentar\"></textarea><input type=\"submit\" name=\"$submit\" value=\"Kommentera\"></form>";
					    	if($_SESSION["user_logged"] == "admin")
					    	{
					    		echo "<br><span>ID = $ID[$i]</span></article>";
					    	}
					    	else
					    	{
								echo "</article>";
							}
						}
						else
						{
							echo "<p style=\"text-align: center;\">Vänligen logga in för att kommentera.</p></article>";
						}
			    	}
		    	else
		    	{
		    		$content[$i] = preg_replace('/<p[^>]*>([\s\S]*?)<\/p[^>]*>/', '', $content[$i]);

		    		$header = preg_replace('/<b[^>]*>([\s\S]*?)<\/b[^>]*>/', '', $content[$i]);
		    		$inledning = preg_replace('/<h2[^>]*>([\s\S]*?)<\/h2[^>]*>/', '', $content[$i]);
		    		if(strlen($bild[$i]) > 6)
			    	{
			    		echo"<article><img src=\"$bild[$i]\" alt=\"bild\"></img><a href=\"?$ID[$i]\">", $header, "</a>", $inledning, "</article>";
			    	}
			    	else
			    	{
			    		echo"<article>", $content[$i], "</article>";
			    	}
		    	}
		    }

		    //Skriv ut kommentarer.
			for ($i=0; $i < Count($ID); $i++) 
			{ 
				$strset = "submit" . "$i";
				$comset = "combox" . "$i";
				if(isset($_POST[$strset]))
				{
					$idpost = $ID[$i];
					$comment = htmlspecialchars(addslashes($_POST[$comset]));
					$sender = $_SESSION["user_logged"];
					$sql = "INSERT INTO `comment` (`comtext`, `comon`, `sender`) VALUES (\"$comment\", $idpost, \"$sender\");";
					if(mysqli_query($conn, $sql))
					{
						echo "<script>location.replace('index.php?", $_SERVER["QUERY_STRING"], "');</script>";
					}
					else
					{
						echo"Error";
					}
				}
			}
		}
		class Comment
		{
			public $ID;
			public $sender; 
			public $comtext; 
			public $comOn;
			public function printer()
			{
				echo "<p>$ID, $sender, $comtext, $comOn </p><br>";
			}
		}
		?>
	</main>
</body>
</html>