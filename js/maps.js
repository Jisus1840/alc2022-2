function myMap() {
    
     var centroSaltillo = new google.maps.LatLng(25.448417,-100.961115);
     var mapProp= {
         center:centroSaltillo,
         zoom:12.9,
		  backgroundColor: "white",
		 
  zoomControl: true,
    zoomControlOptions: {
        position: google.maps.ControlPosition.LEFT_CENTER
    }
		
     };
     var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
     //var marker = new google.maps.Marker({position:centroSaltillo, animation:google.maps.Animation.DROP});
     //marker.setMap(map);
     google.maps.event.addListener(marker,'click',function() {
         var infowindow = new google.maps.InfoWindow({content:"157/18 Reparación de Luminaria"});
         infowindow.open(map,marker);
     });

     var geocoder = new google.maps.Geocoder();
     document.getElementById('submit').addEventListener('click', function() {
         geocodeAddress(geocoder, map);
     });

     function geocodeAddress(geocoder, resultsMap) {
         var address = document.getElementById('address').value;

         geocoder.geocode({'address': address}, function(results, status) {          
           if (status === 'OK') {
             resultsMap.setCenter(results[0].geometry.location);
             /*
             var markerdir = new google.maps.Marker({
               map: resultsMap,
               position: results[0].geometry.location
             });
             */
             resultsMap.setZoom(18);
           } else {
             alert('error al localizar la dirección: ' + status);
           }
         });

         google.maps.event.addListener(map, 'click', function(event) {
             placeMarker(resultsMap, event.latLng);
         });
		
     }

     function placeMarker(map, location) {
         var marker = new google.maps.Marker({
             position: location,
             map: map
         });
         var infowindow = new google.maps.InfoWindow({
             content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
         });
         infowindow.open(map,marker);
     }
     
     function drawMarker (lat, lon, msg) {
         var markerPosition = new google.maps.LatLng(25.40265522, -100.92425119);
         var marker = new google.maps.Marker({
             position:markerPosition, 
             animation:google.maps.Animation.DROP,
             map: map
         });
         var infowindow = new google.maps.InfoWindow({
             content: '1'
         });
         infowindow.open(map,marker);
     }

 }
 
