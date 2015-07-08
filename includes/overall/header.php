<!DOCTYPE html>
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