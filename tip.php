	<?php
	include "header.php";
	?>
	<body>
		<article>
			<form method="POST">
				<textarea name="meddelande"></textarea>
				<input type="submit" name="skic">
			</form>
			<?php
				if(isset($_POST["skic"]))
				{
					$msg = htmlspecialchars(addslashes($_POST["meddelande"]));
					$thisUser = $_SESSION["user_logged"];
					$sql = "INSERT INTO `msgz` (`sender`, `msg`) VALUES (\"$thisUser\", \"$msg\");";
					if(mysqli_query($conn, $sql))
					{
						echo "<script>alert(\"Ditt meddelande har skickats!\"); location.replace(\"tip.php\");</script>";
					}
					else
					{
						echo "Något gick fel :(";
					}
				}
			?>
		</article>
	</body>
</html>