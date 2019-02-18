<!doctype html>
<?php 
include "header.php"; 
if($_SESSION["user_logged"] != "admin")
{
	header("Location: index.php");
}
?>
<body>
	<article>
		<form method="POST" enctype='multipart/form-data'>
			<p>Bild: <input type="file" name="bild"></p>
			<p>Titel:</p> <input type="text" name="titel">
			<p>Inledning:</p> <input type="text" name="inledning">
			<p>Brödtext:</p> <textarea name="texta"></textarea>
			<input type="submit" name="subtext" value="Posta.">
		</form>
		<?php
		@$titel = addslashes($_POST["titel"]);
		@$inl = addslashes($_POST["inledning"]);
		@$text = addslashes(str_replace("\n", "</p><p>", $_POST["texta"]));
		@$fulltext = "";
		@$date = strval(date("d/m/Y") . " - " . date("H:i"));
			if(isset($_POST["subtext"]))
			{
				@$fulltext ="<h2>$titel</h2><b>$inl</b><br><p>$text</p>";
                @$fileName = strval(str_replace(" ", "", ($_FILES["bild"]["name"])));
                //var_dump($fileName);
                @$size = getimagesize($_FILES["bild"]["tmp_name"]); 
                //var_dump($size);
                @$path = "img/$fileName";
				if (strlen($fileName) >3) 
		            {
		                try
		                {
		                   if ($size) 
		                   {
		                        $move = move_uploaded_file($_FILES['bild']['tmp_name'], $path);

		                        if ($move !== false) 
		                        {
		                        	$sql = "INSERT INTO `inlagg` (`Bild`, `Content`, `Date`) VALUES (\"$path\", \"$fulltext\", \"$date\")";
		                        	if(mysqli_query($conn, $sql))
									{
										echo "Artikeln är uppladdad!";
									}
									else
									{
										echo "Något gick fel wtf";
									}
		                            mysqli_close($conn);
		                        }
		                        else if ($move == false)
		                        {
		                            echo "Filen kunde inte laddas upp.";                       
		                        }
		                    }
		                }
		                catch(Exception $e)
		                {
		                 echo $e->getMessage();
		                }
		           }
		           else
		           {
		           		$sql = "INSERT INTO `inlagg` (`Content`, `Date`) VALUES (\"$fulltext\" , \"$date\")";
		           		if(mysqli_query($conn, $sql))
						{
							echo "Artikeln är uppladdad!";
						}
						else
						{
							echo "Något gick fel wtf";
						}
		           }
				}
			?>
		
	</article>
</body>