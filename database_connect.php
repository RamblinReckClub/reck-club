<?php
	$host = 'localhost';
	$port = 3306;
	$database = 'reck_club';
	$username = 'root';
	$password = 'root';
	//$username = 'reck';
	//$password = 'burdell';
	
	$dsn = "mysql:host=$host;port=$port;dbname=$database";
	
	$db = new PDO($dsn, $username, $password);
	
?>
