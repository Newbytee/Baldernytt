<?php 
	//Database
	$host_db = "localhost";
	$user_db = "rcgafudb_rcgafudb";
	$pass_db = "CracKDoWn37";
	$db_name = "rcgafudb_nyheter";

	$conn = mysqli_connect($host_db, $user_db, $pass_db, $db_name);
	if($conn)
	{
		echo "Success!";
	}
	else
	{
		echo "Could not connect to database.";
	}
?>