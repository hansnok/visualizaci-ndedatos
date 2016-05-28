<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Universidades de Chile</title>

        <link rel="stylesheet" href="css/ammap.css" type="text/css">
        <script src="js/ammap.js" type="text/javascript"></script>
        <!-- map file should be included after ammap.js -->
		<script src="js/chileLow.js" type="text/javascript"></script>
		
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
			        mapVar: AmCharts.maps.chileLow,
			        //getAreasFromMap: true,
			        images: [
						<?php 
						include "config.php";
						
						// Get universidades
						$sql = "SELECT id, nombre, latitud, longitud, ubicacion
							FROM universidades
							WHERE ubicacion != 'x' AND latitud is not NULL
							ORDER BY id ASC";
						
						$universidades = $mysqli->query($sql);
										
						foreach ($universidades as $universidad){
							$stringuniversidad = '{
									svgPath: targetSVG,
									zoomLevel: 30,
									scale: 0.7,
									title: "'.$universidad["nombre"].'",
									customData: "'.$universidad["ubicacion"].'",
									latitude: '.(double)$universidad["latitud"].',
									longitude: '.(double)$universidad["longitud"].'	
								},';	
							
							echo $stringuniversidad;							
						}
						?>
			        ]
			    };
			    
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
				            title: "Universidades de Chile",
				            color: "#000000"}
				        ]
				    };

			    mapChile.addLegend(legend);
				    
			    mapChile.write("mapdiv");

			    mapChile.addListener("clickMapObject", function (event) {
				    //document.getElementById("placeholder").innerHTML = '<img src="http://lorempixel.com/200/200/city/' + event.mapObject.customData + '/" />';
				    //alert(event.mapObject.customData);
				    var address = event.mapObject.customData;
				   // $("autocomplete").val(address);
				    //search();
				    initialize(event.mapObject.latitude, event.mapObject.longitude)				    
			  });

			});


			////// Google Maps /////
			
		  var map, places, iw;
		  var markers = [];
		  var autocomplete;
		  
		  function initialize(latitud, longitud) {
		    var myLatlng = new google.maps.LatLng(latitud, longitud);
		    var myOptions = {
		      zoom: 13,
		      center: myLatlng,
		      mapTypeId: google.maps.MapTypeId.ROADMAP
		    }
		    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		    places = new google.maps.places.PlacesService(map);
		    google.maps.event.addListener(map, 'tilesloaded', tilesLoaded);
		    autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'));
		    google.maps.event.addListener(autocomplete, 'place_changed', function() {
		      showSelectedPlace();
		    });
		  }
		  
		  function tilesLoaded() {
		    google.maps.event.clearListeners(map, 'tilesloaded');
		    google.maps.event.addListener(map, 'zoom_changed', search);
		    google.maps.event.addListener(map, 'dragend', search);
		    search();
		  }
		  
		  function showSelectedPlace() {
		    clearResults();
		    clearMarkers();
		    var place = autocomplete.getPlace();
		    map.panTo(place.geometry.location);
		    markers[0] = new google.maps.Marker({
		      position: place.geometry.location,
		      map: map
		    });
		    iw = new google.maps.InfoWindow({
		      content: getIWContent(place)
		    });
		    iw.open(map, markers[0]);
		  }
		  
		  function search() {
		    var type = [];
		    for (var i = 0; i < document.controls.type.length; i++) {
		      if (document.controls.type[i].checked) {
		        type = document.controls.type[i].value;
		      }
		    }
		    
		    autocomplete.setBounds(map.getBounds());
		    
		    var search = {
		      bounds: map.getBounds()
		    };
		    
		    
		    search.types = [ "store", "museum", "clothing_store", "restaurant" ];		    
		    
		    places.search(search, function(results, status) {
		      if (status == google.maps.places.PlacesServiceStatus.OK) {
		        clearResults();
		        clearMarkers();
		        for (var i = 0; i < results.length; i++) {
		          markers[i] = new google.maps.Marker({
		            position: results[i].geometry.location,
		            animation: google.maps.Animation.DROP
		          });
		          google.maps.event.addListener(markers[i], 'click', getDetails(results[i], i));
		          setTimeout(dropMarker(i), i * 200);
		          addResult(results[i], i);
		        }
		      }
		    })
		  }
		  
		  function clearMarkers() {
		    for (var i = 0; i < markers.length; i++) {
		      if (markers[i]) {
		        markers[i].setMap(null);
		        markers[i] == null;
		      }
		    }
		  }
		  
		  function dropMarker(i) {
		    return function() {
		      markers[i].setMap(map);
		    }
		  }
		  
		  function addResult(result, i) {
		    var results = document.getElementById("results");
		    var tr = document.createElement('tr');
		    tr.style.backgroundColor = (i% 2 == 0 ? '#F0F0F0' : '#FFFFFF');
		    tr.onclick = function() {
		      google.maps.event.trigger(markers[i], 'click');
		    };
		    
		    var iconTd = document.createElement('td');
		    var nameTd = document.createElement('td');
		    var icon = document.createElement('img');
		    icon.src = result.icon;
		    icon.setAttribute("class", "placeIcon");
		    icon.setAttribute("className", "placeIcon");
		    var name = document.createTextNode(result.name);
		    iconTd.appendChild(icon);
		    nameTd.appendChild(name);
		    tr.appendChild(iconTd);
		    tr.appendChild(nameTd);
		    results.appendChild(tr);
		  }
		  
		  function clearResults() {
		    var results = document.getElementById("results");
		    while (results.childNodes[0]) {
		      results.removeChild(results.childNodes[0]);
		    }
		  }
		  
		  function getDetails(result, i) {
		    return function() {
		      places.getDetails({
		          reference: result.reference
		      }, showInfoWindow(i));
		    }
		  }
		  
		  function showInfoWindow(i) {
		    return function(place, status) {
		      if (iw) {
		        iw.close();
		        iw = null;
		      }
		      
		      if (status == google.maps.places.PlacesServiceStatus.OK) {
		        iw = new google.maps.InfoWindow({
		          content: getIWContent(place)
		        });
		        iw.open(map, markers[i]);        
		      }
		    }
		  }
		  
		  function getIWContent(place) {
		    var content = "";
		    content += '<table><tr><td>';
		    content += '<img class="placeIcon" src="' + place.icon + '"/></td>';
		    content += '<td><b><a href="' + place.url + '">' + place.name + '</a></b>';
		    content += '</td></tr></table>';
		    return content;
		  }

		  

        </script>
        
		<style>
		#map_canvas {
		  position: absolute;
		  width: 70%;
		  height: 280px;
		  top: 415px;
		  left: 8px;
		  border: 1px solid grey;
		}
		#listing {
		  position: absolute;
		  width: 25%;
		  height: 280px;
		  overflow: auto;
		  left: 915px;
		  top: 415px;
		  cursor: pointer;
		}
		.placeIcon {
		  width: 16px;
		  height: 16px;
		  margin: 2px;
		}
		#resultsTable {
		  font-size: 10px;
		  border-collapse: collapse;
		}
		#locationField {
		  width: 25%;
		  height: 25px;
		  top: 450px;
		  left: 0px;
		  position: absolute;
		}
		
		</style>
		
    </head>
    
<body onload="initialize(-33.45, -70.65)">
    <div>
        <div id="listdiv" style="width:200px; overflow:auto; height:400px; float:right; background-color:#FFFFFF;"></div>
        <div id="mapdiv" style="margin-right:200px; background-color:#E4EFFF; height: 400px;"></div>
        
        <div id="locationField">
		    <input id="autocomplete" type="hidden" value = ""/>
		</div>
		
		<div id="controls">
		    <form name="controls">
		    	<input type="hidden" name="type" value="establishment" onclick="search()" checked="checked"/>
		    </form>
		 </div>
		 
  	     <div id="map_canvas"></div>
 		 <div id="listing"><table id="resultsTable"><tbody id="results"></tbody></table></div>

    </div>
</body>

</html>
</html>