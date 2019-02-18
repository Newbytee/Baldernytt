<?php
	include "header.php";
	?>
	<body>
		<article>
		<?php
			$sql = "SELECT * FROM `msgz` WHERE 1=1 ORDER BY ID DESC";
			if($r = mysqli_query($conn, $sql))
			{
				while($row = mysqli_fetch_row($r))
                {
                    @$a[]  = $row[1];
                    @$b[] = $row[2];
                }

                for ($i=0; $i < Count($a) ; $i++) 
                { 
                	echo "<div style=\"outline: 1px #000 solid; padding: 30px;\"><b>Meddelande från: $a[$i]:</b><p>$b[$i]</p></div>";
                }
			}
		?>
		</article>
	</body>
</html