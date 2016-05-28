
<html>
<head>
	<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<?php 
include "config.php";

// Get universidades
$sql = "SELECT id, nombre, latitud, longitud
		FROM universidades
		WHERE ubicacion != 'x'
		ORDER BY id ASC";

$universidades = $mysqli->query($sql);
$locations = array();
$count = 0;
$locations[$count] = array("x", "y","universidad");
foreach ($universidades as $universidad){
	$count++;
	//$arrayaddress [] = array_map('htmlentities',array($universidad["id"], $universidad["ubicacion"]));
	$locations [$count] = array(
			(double)$universidad["latitud"], 
			(double)$universidad["longitud"], 
			$universidad["nombre"]
	);
	
}
//var_dump($locations);

?>
<script type='text/javascript'>
google.charts.load('current', {'packages': ['geochart']});
google.charts.setOnLoadCallback(drawMarkersMap);

function drawMarkersMap() {
	
	

	var data = google.visualization.arrayToDataTable(<?php echo json_encode($locations); ?>);

	var options = {
		region: 'CL',
		dataMode: 'markers',
		sizeAxis: {minSize:5,  maxSize: 5},
        colorAxis: {minValue: 1, maxValue:1,  colors: ['#B92B3D']},
		resolution: 'provinces',
		enableRegionInteractivity: 'true',
		//legend: 'enable'
		
	};

	var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
	chart.draw(data, options);
	
};
</script>
</head>
<body>
<div id="chart_div" style="width: 900px; height: 700px;"></div>


</body>
</html>