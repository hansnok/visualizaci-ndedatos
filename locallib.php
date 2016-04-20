<?php

function insert_data($data, $mysqli){
	// comprueba que lo que desea guardar no exista en la base de datos previamente
	if(!exist_data($data, $mysqli)){
		
		$name = "'" . $mysqli->real_escape_string($data["name"]) . "'";	
		$location = "'" . $mysqli->real_escape_string($data["location"]) . "'";
		$web = "'" . $mysqli->real_escape_string($data["web"]) . "'";
		
		$queryinsert = "INSERT INTO universidades (nombre, ubicacion, web) VALUES ($name, $location, $web)";
		
		$resultado = $mysqli->query($queryinsert);

		if($resultado === FALSE){
			 printf("Errorcode: %d\n", $mysqli->errno);
		}
		//else{
			//echo "Insertado <br>";
		//}
		
	}
	//else{
		//echo "ya existe en la base de datos <br>";
	//}
}

function exist_data($data, $mysqli){
	
	$name = "'" . $mysqli->real_escape_string($data["name"]) . "'";	
	$location = "'" . $mysqli->real_escape_string($data["location"]) . "'";
	
	$sql = "SELECT *
			FROM universidades
			WHERE nombre = $name AND ubicacion = $location";
	
	$universidad = $mysqli->query($sql);
	
	if($universidad === FALSE){
		 printf("Errorcode: %d\n", $mysqli->errno);

		return FALSE;
	
	}else{
		
		$rows_returned = $universidad->num_rows;
		
		if($rows_returned > 0){
			//echo " * la universidad existe";
			return TRUE;
		}else{
			//echo "* la universidad no  existe";
			return FALSE;
		}
	}
	
}



