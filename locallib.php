<?php

function insert_data($data, $conexion){
	echo "estoy en la funcion 1 ";
	// comprueba que lo que desea guardar no exista en la base de datos previamente
	if(!exist_data($data, $conexion)){
		echo "deberia guardar - ";
		
		$queryinsert = "INSERT INTO universidades (nombre, ubicacion, web)
				VALUES ('".$data['name']."', '".$data['ubicacion']."', '".$data['web']."')";
		echo $queryinsert;
		$resultado = mysqli_query($conexion, "INSERT INTO universidades VALUES (NULL, '".$data['name']."', '".$data['ubicacion']."', '".$data['web']."', NULL)");
		if($resultado){
			echo "guardado <br>";
			printf("La selección devolvió %d filas.\n", $resultado->num_rows);
			
			/* liberar el conjunto de resultados */
			//$resultado->close();
			return TRUE;
		}else{
			echo "caca <br>";
			return FALSE;
		}
		
	}else{
		return FALSE;
	}
}

function exist_data($data, $conexion){
	
	$query = "SELECT *
			FROM universidades
			WHERE nombre = '".$data["name"]."'";
	
	$universidad = mysqli_query($conexion, $query);
	//$universidad =  $conexion->query($query);
	
	if($universidad ){
		echo "La selección devolvió %d filas.\n".$universidad->num_rows;
		
		/* liberar el conjunto de resultados */
		//$universidad->close();
		return TRUE;
	}else{
		echo "retorna malo";
		return FALSE;
	}
	
}