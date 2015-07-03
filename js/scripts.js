function initialise() {
    myLatlng = new google.maps.LatLng(52, 4);
    mapOptions = {
        zoom: 8,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    }
    geocoder = new google.maps.Geocoder();
    infoWindow = new google.maps.InfoWindow;
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
     
    xmlUrl = "veiligstallen.xml";
     request
    loadMarkers();
     
}
 
google.maps.event.addDomListener(window, 'load', initialise); 

function loadMarkers() {
    map.markers = map.markers || []
    downloadUrl(xmlUrl, function(data) {
        var xml = data.responseXML;
        markers = xml.documentElement.getElementsByTagName("Fietsenstalling");
        for (var i = 0; i < markers.length; i++) {
            var coordinaten = markers[i].getAttribute("Coordinaten");
            
            var id = markers[i].getAttribute("ID");
            var address = markers[i].getAttribute("address1")+"<br />"+markers[i].getAttribute("address2")+"<br />"+markers[i].getAttribute("Straat")+"<br />"+markers[i].getAttribute("Postcode");
           
            var point = new google.maps.LatLng(
                parseFloat(markers[i].getAttribute("lat")),
                parseFloat(markers[i].getAttribute("lng")));
            var html = "<div class='infowindow'><b>" + name + "</b> <br/>" + address+'<br/></div>';
            var marker = new google.maps.Marker({
              map: map,
              position: point,
              title: name
            });
            map.markers.push(marker);
            bindInfoWindow(marker, map, infoWindow, html);
        }
    });
}
