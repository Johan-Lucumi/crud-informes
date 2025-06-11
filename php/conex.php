<?php
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="Johan*210905";
$dbname="crud_bd";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//$con->close();
?>