<?php

// conexión a la base de datos

$servidor = "localhost";
$usuario = "local";
$contraseña =  "local";
$bbdd = "data";

//new mysqli('localhost', $usuario, $contraseña, $bbdd);

 $conexion = mysqli_connect('localhost', $usuario, $contraseña, $bbdd);