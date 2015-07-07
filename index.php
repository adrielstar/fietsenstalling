<?php include 'includes/overall/header.php'; ?>
<?php include 'core/models/Stalling_Rest.php'; ?>
<?php include 'vendor/autoload.php'; ?>
<?php

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
        <div class="col-md-10 col-sm-12">
            <?php include 'includes/map.php' ?>
        </div>
    </div>
<?php include 'includes/overall/footer.php' ?>