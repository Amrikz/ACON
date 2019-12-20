<?php
	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$database = "acon";

	// Create connection
	$dbc = mysqli_connect($servername, $username, $password, $database) OR DIE("Error with database connection");
?>