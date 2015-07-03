<?php include 'includes/overall/header.php' ?>
<?php include 'core/function.php' ?>
<br>
    <br>
    <br><br>


    <div class="row ">
        <div class="col-md-2 col-sm-12 ">
            <p>
                <?php
                echo get_omschrijving();
                ?>
            </p>
        </div>
        <div class="col-md-10 col-sm-12">
            <?php include 'includes/map.php' ?>
        </div>
    </div>



    <!--    <div class="container">-->
    <!--        <div class="row">-->
    <!--            <div class="col-md-2 col-sm-12">-->
    <!--                Sidebar content-->
    <!--            </div>-->
    <!--            <div class="col-md-10 col-sm-12">-->
    <!--                <div id="map-canvas"/>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
<?php include 'includes/overall/footer.php' ?>