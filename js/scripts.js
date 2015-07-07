var map;

function initialize() {
    myLatlng = new google.maps.LatLng(51.924215999999990000, 4.481775999999968000);
    mapOptions = {
        zoom: 13,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);

    // Create the search box and link it to the UI element.
    input = /** @type {HTMLInputElement} */(
        document.getElementById('search-input'));

    searchBox = new google.maps.places.SearchBox(
        /** @type {HTMLInputElement} */(input));
    // Listen for the event fired when the user selects an item from the
    // pick list. Retrieve the matching places for that item.
    google.maps.event.addListener(searchBox, 'places_changed', function () {
        places = searchBox.getPlaces();
        bounds = new google.maps.LatLngBounds();
        for (i = 0, place; place = places[i]; i++) {
            bounds.extend(place.geometry.location);
        }
        map.fitBounds(bounds);
    });

    // Bias the SearchBox results towards places that are within the bounds of the
    // current map's viewport.
    google.maps.event.addListener(map, 'bounds_changed', function () {
        var bounds = map.getBounds();
        searchBox.setBounds(bounds);
    });

    // Markers icon
    bike_location = 'img/BikeLocationIcon.png';
    stallingen_ImageIcon = 'img/bike.png';

    // Try HTML5 geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            pos = new google.maps.LatLng(position.coords.latitude,
                position.coords.longitude);

            marker = new google.maps.Marker({
                position: pos,
                map: map,
                icon: bike_location
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

        stallingMarker = new google.maps.Marker({
            position: new google.maps.LatLng(parseFloat(stallingenLatCoordinat), parseFloat(stallingenLngCoordinat)),
            map: map,
            icon: stallingen_ImageIcon
        });
    }

    request = {
        location: pyrmont,
        radius: 500,
        types: ['bicycle_store']
    };
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

google.maps.event.addDomListener(window, 'load', initialize);
