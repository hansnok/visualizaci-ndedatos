<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Google Maps JavaScript API v3 Example: Geocoding Simple</title>
    <link href="https://developers.google.com/maps/documentation/javascript/examples/default.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    
  </head>
  <body onload="initialize()">
    <div>
      <input id="address" type="textbox" style="width:60%" value="Av. Libertador B. O`Higgins 340, Santiago, Santiago">
      <input type="button" value="Geocode" onclick="codeAddress()">
      LAtitud<input type="text" id="lat"/>
      Longitud<input type="text" id="lng"/>

    </div>
    <div id="map_canvas" style="height:60%;top:30px"></div>
    <?php 
    include "config.php";
    
    // Get universidades
    $sql = "SELECT id, ubicacion
		FROM universidades
		ORDER BY id ASC";
    
    $universidades = $mysqli->query($sql);
    
    foreach ($universidades as $universidad){
    	//$arrayaddress [] = array_map('htmlentities',array($universidad["id"], $universidad["ubicacion"]));
    	$arrayaddress [] = array(utf8_encode($universidad["ubicacion"]));
    }
    
    //$address = array_map('htmlentities',$arrayaddress);
    //var_dump($arrayaddress);
    ?>
    <script>
      var geocoder;
      var map;
      var mapOptions = {
          zoom: 17,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
      var marker;
      function initialize() {
        geocoder = new google.maps.Geocoder();
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        codeAddress();
      }
      function JSON_stringify(s, emit_unicode)
      {
         var json = JSON.stringify(s);
         return emit_unicode ? json : json.replace(/[\u007f-\uffff]/g,
            function(c) { 
              return '\\u'+('0000'+c.charCodeAt(0).toString(16)).slice(-4);
            }
         );
      }
  	
      function codeAddress() {
    	var address = <?php echo json_encode($arrayaddress); ?>;
    	
        var address = document.getElementById('address').value;
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            if(marker)
              marker.setMap(null);
            marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
                draggable: true
            });
            google.maps.event.addListener(marker, "dragend", function() {
              document.getElementById('lat').value = marker.getPosition().lat();
              document.getElementById('lng').value = marker.getPosition().lng();
            });
            document.getElementById('lat').value = marker.getPosition().lat();
            document.getElementById('lng').value = marker.getPosition().lng();
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>
  </body>
</html>