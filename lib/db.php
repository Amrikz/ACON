<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "acon";

	// Create connection
	global $dbc;
	$dbc = mysqli_connect($servername, $username, $password, $database) OR DIE("Error with database connection");
?>