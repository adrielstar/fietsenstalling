<?php include 'includes/overall/header.php'; ?>

    <script>
        var stallingen = <?php echo json_encode($call->getStallingen()); ?>
    </script>
    <br>
    <br>
    <br>
    <br>

    <div class="row ">

        <div class="col-md-2 col-sm-12 ">
            <div class="row">
                <div class="col-xs-10 col-xs-offset-2">
                    <label for="location-from" class="abs inside">Van</label>
                    <input type="text" name="location-from" id="location-from" class="rel" placeholder="Huidige locatie" value="" lang="nl-NL" x-webkit-speech="" autocomplete="off">

                    <label for="location-to" class="abs inside">Naar</label>
                    <input type="text" name="location-to" id="location-to" class="rel" placeholder="Postcode" value="" lang="nl-NL" x-webkit-speech="" autocomplete="off">

                    <button class="custom-buttons" type="button" onclick="getLocation()">Huidige locatie</button>
                    <button class="custom-buttons" type="button" onclick="setEnd();return false;">Plan route</button>
                    <button class="custom-buttons" type="button" onclick="">Toon fietsverkopers</button>
                    <div id="demo"></div>
                </div>
                <div class="col-xs-10 col-xs-offset-2">

                </div>
            </div>
            <input id="hideBikeStore" type="checkbox" value="" checked> Show Bike Store<br>
        </div>

<!--        LOGIC-->
        <script type="application/javascript">
            var x = document.getElementById("demo");
            var start = getCookie("latitude") + "," + getCookie("longitude");
            var gamePath;

            console.log("latitude: " + getCookie("latitude"));
            console.log("longitude: " + getCookie("longitude"));

            function setEnd() {
                postcode = document.getElementById("location-to").value;
                $.post("http://maps.googleapis.com/maps/api/geocode/json?address=" + postcode + "+Netherlands",
                    function (data) {
                        calcRoute(data.results[0]["geometry"]["location"]["lat"] + "," + data.results[0]["geometry"]["location"]["lng"]);
                    });
            }

            function calcRoute(me) {
                console.log("caling route   " + me);
                var request = {
                    origin: start,
                    destination: me,
                    unitSystem: google.maps.UnitSystem.IMPERIAL,
                    travelMode: google.maps.DirectionsTravelMode["BICYCLING"]
                };

                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
//                        debugger;
//                        $('#directionsPanel').empty(); // clear the directions panel before adding new directions
                        directionsDisplay.setDirections(response);
                        console.log("RES: " + response);
                    } else {
                        debugger;
                        // alert an error message when the route could nog be calculated.
                        if (status == 'ZERO_RESULTS') {
                            alert('No route could be found between the origin and destination.');
                        } else if (status == 'UNKNOWN_ERROR') {
                            alert('A directions request could not be processed due to a server error. The request may succeed if you try again.');
                        } else if (status == 'REQUEST_DENIED') {
                            alert('This webpage is not allowed to use the directions service.');
                        } else if (status == 'OVER_QUERY_LIMIT') {
                            alert('The webpage has gone over the requests limit in too short a period of time.');
                        } else if (status == 'NOT_FOUND') {
                            alert('At least one of the origin, destination, or waypoints could not be geocoded.');
                        } else if (status == 'INVALID_REQUEST') {
                            alert('The DirectionsRequest provided was invalid.');
                        } else {
                            alert("There was an unknown error in your request. Requeststatus: nn"+status);
                        }
                    }
                });

                gamePath = "comgooglemaps://?saddr=" + start + "&daddr=" + me + "&directionsmode=bicycling";
                document.getElementById("gameAnchor").setAttribute("href", gamePath);
            }

        </script>
<!--        END LOGIC-->

        <div class="col-md-10 col-xs-12">
            <?php include 'includes/map.php' ?>
            <a id="gameAnchor" href="comgooglemaps://">Go to the google maps app</a>
        </div>
    </div>
<?php include 'includes/overall/footer.php' ?>