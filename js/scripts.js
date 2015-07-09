var map = null;
var infoWindow = new google.maps.InfoWindow();
var storeInfowindow = new google.maps.InfoWindow();
var stallingeninfowindow = new google.maps.InfoWindow();
var arrayStoreMarkers = [];
var directionsDisplay = new google.maps.DirectionsRenderer();
var directionsService = new google.maps.DirectionsService();
var stalingmarkermarkers = [];
var htmls = [];
var to_htmls = [];

var directionDisplay;
var directionsService = new google.maps.DirectionsService();

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

function initialize() {
    myLatlng = new google.maps.LatLng(51.924215999999990000, 4.481775999999968000);

    // set direction render options
    var rendererOptions = { draggable: true };
    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

    mapOptions = {
        zoom: 13,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);

    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));
    google.maps.event.addListener(map, 'click', function() {
        infoWindow.close();
    });
    // Markers icon
    bike_location = 'img/BikeLocationIcon.png';
    stallingen_ImageIcon = 'img/bike.png';

    // Try HTML5 geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            setCookie("latitude",position.coords.latitude,1);
            setCookie("longitude",position.coords.longitude,1);

            pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            contentString = 'current location';

            // request to google api to get all bicycle_store
            request = {
                location: myLatlng,
                radius: 1000,
                types: ['bicycle_store']
            };

            service = new google.maps.places.PlacesService(map);
            service.nearbySearch(request, callback);


            locationInfowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var currentLocationMarker = new google.maps.Marker({
                position: pos,
                map: map,
                icon: bike_location
            });

            google.maps.event.addListener(currentLocationMarker, 'click', function () {
                locationInfowindow.open(map, currentLocationMarker);
            });

            map.setCenter(pos);
        }, function () {
            handleNoGeolocation(true);
        });
    } else {
        // Browser doesn't support Geolocation
        handleNoGeolocation(false);
    }


    // create Stallingen Markers
    for (k = 0; k < stallingen.length; k++) {

        stallingenLatCoordinat = parseFloat(stallingen[k]["lat"]);
        stallingenLngCoordinat = parseFloat(stallingen[k]["lng"]);
        stallingName = stallingen[k]["name"];
        stallingAdres = stallingen[k]["Adres"];
        stallingPostcode = stallingen[k]["Postcode"];
        stallingPlaats = stallingen[k]["Plaats"];
        stallingCapaciteit = stallingen[k]["Capaciteit"];
        stallingOpeningstijden = stallingen[k]["Openingstijden"];

        stallingOpeningstijdenSplits = stallingOpeningstijden.match(/.{1,17}/g);
        stallingenLatLng = new google.maps.LatLng(parseFloat(stallingenLatCoordinat), parseFloat(stallingenLngCoordinat));
        stallingMarker = new google.maps.Marker({
            position: stallingenLatLng ,
            map: map,
            icon: stallingen_ImageIcon,
            title: stallingName
        });
        var html = '<br>Directions: <a href="javascript:tohere(' + k + ')">To here<\/a> ';

        var k = stalingmarkermarkers.length;
        latlng = stallingenLatLng;

        // The info window version with the "to here" form open
        to_htmls[k] = html + '<br>Directions: <b>To here<\/b> '+
        '<br>Address:<form action="javascript:getDirections()">' +
        '<input type="text" SIZE=40 MAXLENGTH=40 name="saddr" id="saddr" value="" placeholder="Empty is current location!" /><br>' +
        '<INPUT value="Get Directions" TYPE="button" onclick="getDirections()"><br>' +
        'Walk <input type="checkbox" name="walk" id="walk" /> &nbsp; Bike <input type="checkbox" name="bike" id="bike" />' +
        '<input type="hidden" id="daddr" value="' + latlng +
        '"/>';

        stallingenDetails = '<h5>' + stallingName + '</h5>'
        + '<h6> Adres: ' + stallingAdres + '</h6>'
        + '<h6> Postcode: ' + stallingPostcode + '</h6>'
        + '<h6> Plaats: ' + stallingPlaats + '</h6>'
        + '<h6> Capaciteit: ' + stallingCapaciteit + '</h6>'
        + '<h6> Openingstijden:</h6>'
        + '<h6> ' + stallingOpeningstijdenSplits[5] + '</h6>'
        + '<h6> ' + stallingOpeningstijdenSplits[6] + '</h6>'
        + '<h6> ' + stallingOpeningstijdenSplits[7] + '</h6>'
        + '<h6> ' + stallingOpeningstijdenSplits[0] + '</h6>'
        + '<h6>  ' + stallingOpeningstijdenSplits[1] + '</h6>'
        + '<h6>  ' + stallingOpeningstijdenSplits[2] + '</h6>'
        + '<h6> ' + stallingOpeningstijdenSplits[3] + '</h6>'
        + '<h6> ' + stallingOpeningstijdenSplits[4] + '</h6>'
        + html;


        stallingenInfoWindow(stallingMarker, stallingenDetails);
        stalingmarkermarkers.push(stallingMarker);
        htmls[k] = html;
    }
}

// ===== request the directions =====
function getDirections() {

    var request = {};
    if (document.getElementById("walk").checked) {
        request.travelMode = google.maps.DirectionsTravelMode.WALKING;
    } else {
        request.travelMode = google.maps.DirectionsTravelMode.DRIVING;
    }

    if (document.getElementById("bike").checked) {
        request.travelMode = google.maps.DirectionsTravelMode.BICYCLING;
    } else {
        request.travelMode = google.maps.DirectionsTravelMode.DRIVING;
    }
    // ==== set the start and end locations ====
    var saddr = document.getElementById("saddr").value;
    var daddr = document.getElementById("daddr").value;

    request.origin = start , saddr;
    request.destination = daddr;
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        } else alert("Directions not found:" + status);
    });
}


// This function picks up the click and opens the corresponding info window
function myclick(i) {
    google.maps.event.trigger(stalingmarkermarkers[i], "click");
}


// functions that open the directions forms
function tohere(i) {

    infoWindow.setContent(to_htmls[i]);
    infoWindow.open(map, stalingmarkermarkers[i]);
}

/**
 *
 * @param results
 * @param status
 */
function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
    }
}


/**
 *
 * @param place
 */
function createMarker(place) {
    var placeLoc = place.geometry.location;
    storeIcon = 'img/BikeStoreIcon.png';
    var storeBikeMarker = new google.maps.Marker({
        map: map,
        icon: storeIcon,
        position: place.geometry.location
    });

    arrayStoreMarkers.push(storeBikeMarker);

    var request = {reference: place.reference};
    service.getDetails(request, function (details, status) {
        google.maps.event.addListener(storeBikeMarker, 'click', function () {
            storeInfowindow.setContent("<h5>" + details.name + "</h5>"
            + details.formatted_address + "<br />"
            + "<a  id='demo' href=" + details.website + '" target="_blank">' + details.website + "</a>" +
            "<br />" + details.formatted_phone_number);
            storeInfowindow.open(map, this);
        });
    });
}

/**
 *
 * @param errorFlag
 */
function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
        var content = 'Error: The Geolocation service failed.';
    } else {
        var content = 'Error: Your browser doesn\'t support geolocation.';
    }

    options = {
        map: map,
        position: new google.maps.LatLng(51.924215999999990000, 4.481775999999968000),
        content: content
    };

    infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
}


function stallingenInfoWindow(stallingMarker, stallingenDetails) {
    google.maps.event.addListener(stallingMarker, 'click', function () {
        if (!stallingMarker.open) {
            infoWindow.setContent(stallingenDetails);
            infoWindow.open(map, stallingMarker);
            stallingMarker.open = true;
        }
        else {
            infoWindow.close(map, stallingMarker);
            stallingMarker.open = false;
        }
    });
}

google.maps.event.addDomListener(window, 'load', initialize);


//var gamePath = "comgooglemaps://?saddr=" + start + "&daddr=" + end + "&directionsmode=bicycling";



