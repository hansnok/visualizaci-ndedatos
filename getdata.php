<?php
include "simple_html_dom.php";
include "config.php";
include "locallib.php";

$mainpageurl = "http://www.cned.cl/public/secciones/seccionestadisticas/Estadisticas_Instituciones.aspx?opcBusquedaCSE=9_3_3";

$suburl = "http://www.cned.cl/public/secciones/seccionestadisticas/Estadisticas_Ficha_Institucion.aspx?idinstitucion=";

$page = file_get_html($mainpageurl);


$universidades = array();
echo "gola";
// Find all links
foreach($page->find("table[width='90%']") as $row){

	foreach ($row->find("tr") as $td){
		
		//get id institución para construir url de mas info
		$onlick = explode("VerInstitucion", explode("=", $td->find("td")[0]->onclick)[0]);

		if( is_numeric($onlick[1]) ){
			
			$urlinfopage = $suburl.$onlick[1];
		
			// Ingresa a la pagina donde se encuentran detallas las distintas sedes que posee la universidad
			$infopage = file_get_html($urlinfopage);

			foreach ($infopage->find("a[href^=JavaScript:VerDetalleSede]") as $sedes){
			
				$universidad = array(
						"name" => $td->find("td")[0],
						"ubicacion" => $sedes->plaintext,
						"web" => $td->find("td")[2]
				);
				echo "llamada para guardar".$td->find("td")[0];
				// inserta todas las universidades con sus respectivas sedes.
				insert_data($universidad, $conexion);
				
			
			}

		}
		
	}

}
mysqli_close();
