/**
 * Created by Luiz on 16/03/2017.
 */


$.ajaxSetup({
    async: false
});

function initMap() {
    var location = $('#location').val();

    var script = 'https://maps.googleapis.com/maps/api/geocode/json?address=' + location + '&key=AIzaSyCz22xAk7gDzvTEXjqjL8Goxu_q12Gt_KU';

    $.getJSON(script, function (json) {
        var lat = json.results[0].geometry.location.lat;
        var lng = json.results[0].geometry.location.lng;

        localStorage.setItem('lat', lat);
        localStorage.setItem('lng', lng);

    });

    var lat = parseFloat(localStorage.getItem('lat'));
    var lng = parseFloat(localStorage.getItem('lng'));

    var uluru = {lat: lat, lng: lng};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: uluru
    });

    var marker = new google.maps.Marker({
        position: uluru,
        map: map
    });

    var infowindow = new google.maps.InfoWindow({map: map});

    infowindow.open(map, marker);
    infowindow.setContent(document.getElementById('streetMap').value);

    marker.addListener('click', function () {
        infowindow.open(map, marker);
    });


}
