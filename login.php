 <!doctype html>
	<?php include "header.php";?>
	<article>
		<form method="POST">
			<p>Användarnamn: <input type="Text" name="user"></p>
			<p>Lösenord: &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; <input type="Password" name="pass"></p>
			<input type="submit" name="sub" value="Logga in">
			<input type="submit" name="create" value="Skapa konto">

				<?php
				@$user = $_POST["user"];
				if(strlen($user)> 3)
				{
					$user = htmlspecialchars(strtolower($_POST["user"]));
				}
				else
				{
					$user = "null";
				}
				@$pass = hash("sha256", htmlspecialchars($_POST["pass"]));
				$a = array();
				$b = array();
				if(isset($_POST["sub"]))
				{
					$sql = "SELECT * FROM `users` WHERE username = \"$user\"";
					if ($result = mysqli_query($conn,$sql)) 
					{
						if(isset($_POST["sub"]))
						{
						     while($row = mysqli_fetch_row($result))
						    {
						        $a[]  = $row[0];
						        $b[] = $row[1];
						    }
						    #var_Dump($a, $b);
						    if(Count($b)>0)
						    {
							    if($pass == $b[0])
							    {
							    	echo"Logged in";

							    	$_SESSION["user_logged"] = $user;
							    	header("Location: index.php");
							    }
							    else
							    {
							    	echo "<br>Failed to login.";
							    }
						    }
						    else
						    {
						    	echo "<br>Failed to login.";
						    }
						}
					}
				}
				else if (isset($_POST["create"]))
				{
					$sql = "SELECT * FROM `users` WHERE `username` = \"$user\"";
					if ($result = mysqli_query($conn, $sql)) 
	                {
	                     while($row = mysqli_fetch_row($result))
	                    {
	                        @$a[]  = $row[1];
	                        @$b[] = $row[2];
	                    }
	                    if(Count($a) > 0)
	                    {
	                    	echo "<br>Användaren \"$user\" finns redan.";
	                    }
	                    else
	                    {
	                    	$sql = "INSERT INTO `users` (`username`, `password`) VALUES (\"$user\",  \"$pass\");";
	                    	if(mysqli_query($conn, $sql))
	                    	{
	                    		echo "<br>Användaren $user skapad!";
	                    	}
	                    	else
	                    	{
	                    		echo "Något gick fel wtf<br>";	                    		
	                    		var_dump($user, $pass);
	                    	}
	                    }
	                }

				}
				?>
		</form>
	</article>
</body>
</html>