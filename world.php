
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Universidades de Chile</title>

<link rel="stylesheet" href="css/ammap.css" type="text/css">
<script src="js/ammap.js" type="text/javascript"></script>
<!-- map file should be included after ammap.js -->
<script src="js/worldLow.js" type="text/javascript"></script>

<script src="js/jquery-2.2.4.min.js" type="text/javascript"></script>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>

<script>
	var mapChile;
	
	// svg path for target icon
	var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";

			AmCharts.ready(function() {
			mapChile = new AmCharts.AmMap();

			mapChile.imagesSettings = {
				rollOverColor: "#CC0000",
				rollOverScale: 3,
				selectedScale: 3,
				selectedColor: "#FF0000",
				unlistedAreasColor: "#DDDDDD",
				rollOverOutlineColor: "#FFFFFF",
				rollOverColor: "#CC0000",
				balloonText: "[[title]] - Dirección:  [[customData]]"
			};

			mapChile.areasSettings = {
			outlineThickness:0.8,
                        autoZoom: true
			};

			var dataProvider = {
			mapVar: AmCharts.maps.worldLow};
			
		    mapChile.dataProvider = dataProvider;

		    mapChile.objectList = new AmCharts.ObjectList("listdiv");
		    mapChile.showImagesInList = true;

		    var legend = {
			        width: 200,
			        backgroundAlpha: 0.5,
			        backgroundColor: "#FFFFFF",
			        borderColor: "#666666",
			        borderAlpha: 1,
			        bottom: 345,
			        left: 75,
			        horizontalGap: 10,
			        data: [
			            {
			            title: "World",
			            color: "#000000"}
			        ]
			    };

		    mapChile.addLegend(legend);
			    
		    mapChile.write("mapdiv");
		    
</script>
	
</head>
    
    <body >
        <div>
            <div id="listdiv" style="width:200px; overflow:auto; height:400px; float:right; background-color:#FFFFFF;"></div>
            <div id="mapdiv" style="margin-right:200px; background-color:#E4EFFF; height: 400px;"></div>

        </div>
    </body>

    </html>
    </html>