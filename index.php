<?php include 'includes/overall/header.php'; ?>

<?php
//https://maps.googleapis.com/maps/api/directions/json?origin=lat,lng&destination=lat,lng


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
            CLICK TO PLAN
        </div>
        <div class="col-md-10 col-xs-12">
            <?php include 'includes/map.php' ?>
        </div>
    </div>
<?php include 'includes/overall/footer.php' ?>