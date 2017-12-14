
$( function() {
    $( "#datepicker" ).datepicker({
        firstDay: 1,
        dateFormat: 'd-M-yy'
    });
  });



 $('#timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: 60,
    defaultTime: '15',
    startTime: '3:00',
    dynamic: true,
    dropdown: true,
    scrollbar: true
});

// LOCATION VARS 
var autocomplete, sTextAddress, sLatitude, sLongitude;

// INIT AUTOCOMPLETE
function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'));
    autocomplete.addListener('place_changed', getAddress);
}

// SAVE SELECTED LOCATION TO VARS
function getAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    sTextAddress = place.formatted_address;
    sLatitude = place.geometry.location.lat();
    sLongitude = place.geometry.location.lng();
};

// GEOLOCATE IS CAUSING PROBLEMS IF LEFT OUT
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}