<div class="navbar navbar-custom navbar-fixed-top">
    <div class="navbar-header"><a class="navbar-brand" href="#">Veiligstalling</a>
        <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
    </div>
    <script>
        function calcRoute() {
            var request = {
                origin: start,
                destination: end,
                unitSystem: google.maps.UnitSystem.IMPERIAL,
                travelMode: google.maps.DirectionsTravelMode["BICYCLING"]
            };

            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    $('#directionsPanel').empty(); // clear the directions panel before adding new directions
                    directionsDisplay.setDirections(response);
                    console.log(response);
                } else {
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
        }
    </script>
    <div class="navbar-collapse collapse">
        <form action="#" onSubmit="calcRoute();return false;" id="postcode-form" class="navbar-form">
            <div class="form-group" style="display:inline;">
                <div class="input-group">
                    <div class="input-group-btn">
                    <!--                    <input type="text" id="search-input" class="form-control" placeholder="What are searching for?">-->
                    <!--                    <span class="input-group-addon"><button type="button" class="glyphicon glyphicon-search"></button> </span>-->
                            <input type="text" id="postcode-field" class="form-control" placeholder="Postcode">
                        <button type="submit" id="postcode-post" class="btn btn-default">Search</button>
                    </div>
                </div>
            </div>
        </form>
        <script>
            var form = document.getElementById("postcode-form");

            document.getElementById("postcode-post").addEventListener("click", function () {
//                form.submit();

                // check if is postcode regexp
                // if is result
                //button click or enter (submit)
                postcode = document.getElementById("postcode-field").value;
                $.post("http://maps.googleapis.com/maps/api/geocode/json?address="+postcode+", Netherlands",
                    function (data, status) {
                        start = data.results[0]["geometry"]["location"]["lat"] + "," + data.results[0]["geometry"]["location"]["lng"];
                        console.log("start: " + start);
                    });
            });
        </script>
    </div>
</div>
</form>
</div>
</div>

<!--52.0611978,4.4929534-->
<!--51.9254106,4.4886792-->