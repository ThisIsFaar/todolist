<?php

$host = 'localhost';
$db = 'ToDoList';
$dsn = "mysql:host=$host;dbname=$db";
$username = 'root';
$password = '';

try{
	
	$conn = new PDO($dsn, $username, $password );

} catch( PDOException $e) {
	
	//printing error
	echo $e->getMessage();
	die();
}

?>