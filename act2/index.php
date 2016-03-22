<?php
include "simple_html_dom.php";

$pageurl = "http://www.latercera.com/";
$html = file_get_html($pageurl);

$resumen = "<h1>RESUMEN</h1>";
$resumen .= "<p>La pagina analizada es ".$pageurl."</p>";

$form = "<a href='index.php?action=csv'> Descargar URL en csv</a> - OJO el servidor web (xampp or mamp) debe tener permisos de escritura para poder generar el CSV.";

$urls = array();
$table = "<table border = 1>";
$table .= "<tr> <th>Numero</th> <th>URL</th> </tr>";
$counter = 1;

if($_GET['action'] == "csv"){

	$csvname = "url". time().".csv";
	$csv = fopen($csvname, 'w+') or die('No se pudo crear el csv.');
	$continue = true;
}

// Find all links
foreach($html->find('a') as $element){
	
	// regex for matching urls
	if( preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/", $element->href) ){
		if( !in_array($element->href, $urls)){
			
			$urls[] = $element->href;
			
			if($continue){
				$datacsv .=	$element->href."\n";
			}
			
			$table .= "<tr><td>".$counter."</td><td>".$element->href."</td></tr>";
			
			$counter++;
		}
	}
}

$table .= "</table>";
$resumen .= "<p>Se encontraron ".($counter -1)." URL distintas en la pagina</p>";

if($_GET['action'] != "csv"){

	$csvname = "url". time().".csv";
	$filehandle = fopen($csvname, 'w+') or die('No se pudo crear el csv.');
	
	echo $resumen."";
	echo $form."<br><br>";
	echo $table;
}else{
	fwrite($csv, $datacsv);
	fclose($filehandle);
	
	header('Content-Type: application/x-octet-stream');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Last-Modified: '.date('D, d M Y H:i:s'));
	header('Content-Disposition: attachment; filename="url'. time()  .'.csv"');
	header("Content-Length: ".filesize($csvname));
	// echo $csvContent;
	
	// delete file
	// unlink($csvName);
	
	echo($datacsv);
}

