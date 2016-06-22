<?php

// conexión a la base de datos

$server = "localhost";
$user = "root";
$pass =  "123123";
$bbdd = "data";

//new mysqli('localhost', $usuario, $contraseña, $bbdd);

//$conexion = mysqli_connect('localhost', $usuario, $contraseña, $bbdd);

$mysqli = new mysqli($server,$user, $pass, $bbdd);
 
if ($mysqli->connect_error) {
 	die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
 
//mysqli_set_charset($conexion, "utf8");

if (!$mysqli->set_charset("utf8")) {
	printf("Error loading character set utf8: %s\n", $mysqli->error);
	exit();
} else {
	//printf("Current character set: %s\n", $mysqli->character_set_name());
}
