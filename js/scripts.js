var map;
var infoWindow = new google.maps.InfoWindow();
var storeInfowindow = new google.maps.InfoWindow();
var stallingeninfowindow = new google.maps.InfoWindow();

function initialize() {
    myLatlng = new google.maps.LatLng(51.924215999999990000, 4.481775999999968000);
    mapOptions = {
        zoom: 13,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);

    // Markers icon
    bike_location = 'img/BikeLocationIcon.png';
    stallingen_ImageIcon = 'img/bike.png';

    // Try HTML5 geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
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

            currentLocationMarker = new google.maps.Marker({
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

        stallingMarker = new google.maps.Marker({
            position: new google.maps.LatLng(parseFloat(stallingenLatCoordinat), parseFloat(stallingenLngCoordinat)),
            map: map,
            icon: stallingen_ImageIcon
        });


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
        + '<h6> ' + stallingOpeningstijdenSplits[4] + '</h6>';


        stallingenInfoWindow(stallingMarker, stallingenDetails);

    }
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
