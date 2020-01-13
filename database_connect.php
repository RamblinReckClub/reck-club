<?php
$host = '127.0.0.1';
$port = getenv('DB_PORT');
$database = 'reck_club';
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

$dsn = "mysql:host=$host;port=$port;dbname=$database";

$db = new PDO($dsn, $username, $password);

?>
