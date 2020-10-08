<?php
	$server = getenv("DB_HOST");
	$username = getenv("DB_USER");
	$password = getenv("DB_PASS");
	$db = getenv("DB_NAME");
	$conn = mysqli_connect($server, $username, $password, $db);
?>