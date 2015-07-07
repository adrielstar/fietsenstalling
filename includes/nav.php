<div class="navbar navbar-custom navbar-fixed-top">
    <div class="navbar-header"><a class="navbar-brand" href="#">Veiligstalling</a>
        <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
    </div>
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li class="active"><a href="">Home</a></li>
            <li>&nbsp;</li>
        </ul>
        <form id="postcode-form" class="navbar-form">
            <div class="form-group" style="display:inline;">
                <div class="input-group">
                    <div class="input-group-btn">
                    <!--                    <input type="text" id="search-input" class="form-control" placeholder="What are searching for?">-->
                    <!--                    <span class="input-group-addon"><button type="button" class="glyphicon glyphicon-search"></button> </span>-->
                            <input type="text" id="postcode-field" class="form-control" placeholder="Postcode">
                        <button type="button" id="postcode-post" class="btn btn-default">Search</button>
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
                        console.log("lat: " + data.results[0]["geometry"]["location"]["lat"]);
                        console.log("lng: " + data.results[0]["geometry"]["location"]["lng"]);
                    });
            });
        </script>
    </div>
</div>
</form>
</div>
</div>