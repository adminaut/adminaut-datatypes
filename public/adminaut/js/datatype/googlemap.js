function placeMarker($element, location) {
    var marker = $element.data('marker');
    if (marker == null) {
        marker = new google.maps.Marker({
            position: location,
            map: $element.data('map')
        });
        $element.data('marker', marker);
    } else {
        marker.setPosition(location);
    }
}

(function ($) {
    appendScript('https://maps.googleapis.com/maps/api/js?key=' + google_api);

    $(window).load(function () {
        $('.datatype-map').each(function () {
            var $this = $(this);
            var identifier = $this.attr('id');
            var $latElement = $('#' + identifier + '-lat');
            var $lngElement = $('#' + identifier + '-lng');
            var location = new google.maps.LatLng(parseFloat($latElement.val()) || 0, parseFloat($lngElement.val()) || 0);

            if($latElement.val() && $lngElement.val() && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                }, function() {
                    console.log("Your browser not support Geolocation");
                });
            }

            var map = new google.maps.Map($this[0], {
                zoom: 4,
                center: location
            });

            $this.data('map', map);

            if ($latElement.val() && $latElement.val()) {
                placeMarker($this, location);
                map.setZoom(16);
            }

            google.maps.event.addListener(map, 'click', function (event) {
                placeMarker($this, event.latLng);
                $latElement.val(event.latLng.lat().toFixed(6));
                $lngElement.val(event.latLng.lng().toFixed(6));
            });

            $latElement.on('change', function(){
                placeMarker($this, new google.maps.LatLng(parseFloat($(this).val()) || 0, parseFloat($lngElement.val()) || 0));
            });

            $lngElement.on('change', function(){
                placeMarker($this, new google.maps.LatLng(parseFloat($latElement.val()) || 0, parseFloat($(this).val()) || 0));
            });
        });
    });
})(jQuery);