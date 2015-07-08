<!DOCTYPE html>
<script>
    var isFinished = false;
    var start;
    var end;

    var getLocation = function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
            isFinished = true;
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    var showPosition = function (position) {
        start = position.coords.latitude + "," + position.coords.longitude;
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
<?php include 'vendor/autoload.php'; ?>
<?php include 'core/models/Stalling_Rest.php'; ?>
<?php
$call = new Stalling_Rest();
$stallingen = $call->getStallingen();
?>
<!-- head -->
   <?php include 'includes/head.php'; ?>
<!-- head end -->

<body>
    <!-- Navigation -->
    <?php include 'includes/nav.php'; ?>
    <!-- Navigation end -->

    <!-- Put your page content here! -->

<div class="container-fluid" id="main">