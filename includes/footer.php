
<!--<!-- script references -->
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>-->
<!---->
<!--<script src="js/scripts.js"></script>-->
<!--<!-- Latest compiled and minified JavaScript -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
<script>
    /**
     * Hide bike Store
     */
    function hideBikestore() {
        if (arrayStoreMarkers) {
            for (var i = 0; i < arrayStoreMarkers.length; i++) {
                arrayStoreMarkers[i].setMap(null);
            }
        }
    }
    /**
     *  show bike store
     */
    function showBikeStore() {
        if (arrayStoreMarkers) {
            for (var i = 0; i < arrayStoreMarkers.length; i++) {
                arrayStoreMarkers[i].setMap(map);
            }
        }
    }

    $('#hideBikeStore').change(function() {
        if( $('#hideBikeStore').prop("checked")) {
            showBikeStore();
        }
        else  {
            hideBikestore();
        }
    });
</script>