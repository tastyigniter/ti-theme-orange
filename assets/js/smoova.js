function initAutocomplete(input, action) {
    var options = {
        // bounds: defaultBounds,
        // types: ['address'],
        componentRestrictions: {country: 'au'}
    };

    autocomplete = new google.maps.places.Autocomplete(input, options);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle(
                {center: geolocation, radius: position.coords.accuracy});
            autocomplete.setBounds(circle.getBounds());
            if ($('#search-query').val().length === 0) {
                $('#search-query-coordinates').val(position.coords.latitude + ', ' + position.coords.longitude);
                $('#search-query-button').click();
            }
        });
    }

    autocomplete.addListener('place_changed', function () {
        action.click();
    });
}

// Code goes here

function initGoogleMapLocation(lat, lng) {
    var map = null;
    var myMarker;
    var myLatlng;

    function initializeGMap(lat, lng) {
        myLatlng = new google.maps.LatLng(lat, lng);

        var myOptions = {
            zoom: 12,
            zoomControl: true,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        myMarker = new google.maps.Marker({
            position: myLatlng
        });
        myMarker.setMap(map);
    }

    // Re-init map before show modal
    $('#myModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        initializeGMap(button.data('lat'), button.data('lng'));
        $("#location-map").css("width", "100%");
        $("#map_canvas").css("width", "100%");
    });

    // Trigger map resize event after modal shown
    $('#myModal').on('shown.bs.modal', function() {
        google.maps.event.trigger(map, "resize");
        map.setCenter(myLatlng);
    });
}
