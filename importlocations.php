<?php
include "config.php";
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding("UTF-8");
$csvuniversidades = file("locations.csv") or die("can't open file");

$address = array();
$count = 1;
foreach ($csvuniversidades as $line) {
	$var = explode(";", $line);
	//echo $var[1]."<br>";
	$address [$count] = $var[1];
	$count++;
}

fclose($csvuniversidades);

// Get universidades
$sql = "SELECT *
		FROM universidades
		ORDER BY id ASC";

$universidades = $mysqli->query($sql);

$count = 1;
foreach ($universidades as $universidad){
	// Update universidades
	$queryupdate = "UPDATE universidades SET ubicacion ='".$address[$count]."' WHERE id ='".$universidad["id"]."'";
	
	echo $queryupdate."<br>";
	$resultado = $mysqli->query($queryupdate);
	//var_dump($universidad);
	$count++;
}
