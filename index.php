<?php include 'includes/overall/header.php'; ?>
    <script>
        var isFinished = false;

        var getLocation = function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
                isFinished = true;
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        var showPosition = function (position) {
            a = "Latitude: " + position.coords.latitude + " Longitude: " + position.coords.longitude;
            console.log(a);
        }

        function sleep(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds) {
                    break;
                }
            }
        }

        getLocation();
        while (!isFinished) {
            // wait
            sleep(500);
        }
    </script>
<!--<script>-->
<!--    $(document).ready(function(){-->
<!--        $("#postcode-post").click(function(){-->
<!--                $.post("http://maps.googleapis.com/maps/api/geocode/json?",-->
<!--                    {-->
<!--                        address: "3031PD, Netherlands"-->
<!--                    },-->
<!--                    function (data, status) {-->
<!--                        alert("Data: " + data + "\nStatus: " + status);-->
<!--                    });-->
<!--            }});-->
<!--    });-->
<!--</script>-->
<?php include 'core/models/Stalling_Rest.php'; ?>
<?php include 'vendor/autoload.php'; ?>
<?php
//https://maps.googleapis.com/maps/api/directions/json?origin=lat,lng&destination=lat,lng

$call = new Stalling_Rest();
$stallingen = $call->getStallingen();
?>
    <script>
        var stallingen = <?php echo json_encode($call->getStallingen()); ?>
    </script>
    <br>
    <br>
    <br>
    <br>

    <div class="row ">
        <div class="col-md-2 col-sm-12 ">
        </div>
        <div class="col-md-10 col-xs-12">
            <?php include 'includes/map.php' ?>
        </div>
    </div>
<?php include 'includes/overall/footer.php' ?>