<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>amMap example</title>

        <link rel="stylesheet" href="css/ammap.css" type="text/css">
        <script src="js/ammap.js" type="text/javascript"></script>
        <!-- check ammap/maps/js/ folder to see all available countries -->
        <!-- map file should be included after ammap.js -->
		<script src="js/chileLow.js" type="text/javascript"></script>
        <script>
        var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";

			var map = AmCharts.makeChart("mapdiv", {
				type: "map",

				balloon: {
					color: "#CC0000"
				},
				dataProvider: {
					map: "chileLow",
					getAreasFromMap: true,
					<?php 
					include "config.php";
					
					// Get universidades
					$sql = "SELECT id, nombre, latitud, longitud
						FROM universidades
						WHERE ubicacion != 'x'
						ORDER BY id ASC";
					
					$universidades = $mysqli->query($sql);
					
					$count = 1;					
					foreach ($universidades as $universidad){
						
						if($count == 1){
							$stringuniversidad = 'images: [{
									svgPath: targetSVG,
									zoomLevel: 5,
									scale: 0.5,
									title: "'.$universidad["nombre"].'",
									latitude: '.(double)$universidad["latitud"].',
									longitude: '.(double)$universidad["longitud"].'	
								},';	
						}else if($count > 1){
							$stringuniversidad = '{
									svgPath: targetSVG,
									zoomLevel: 5,
									scale: 0.5,
									title: "'.$universidad["nombre"].'",
									latitude: '.(double)$universidad["latitud"].',
									longitude: '.(double)$universidad["longitud"].'
								},';
						}
						
						echo $stringuniversidad;
						$count++;
					}
					echo ']';
					?>
					
				},

				areasSettings: {
					autoZoom: true,
					selectedColor: "#C5DFF5"
				},

				smallMap: {}
			});

        </script>
    </head>

    <body>
        <div id="mapdiv" style="width: 800px; background-color:#EEEEEE; height: 500px;"></div>
    </body>

</html>