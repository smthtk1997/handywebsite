<!DOCTYPE html>
<html>
<head>

</head>
<body>

<p>Click the button to get your location.</p>

<button onclick="getLocation()">Try It</button>

{{--<button onclick="initMap()">Show map</button>--}}

<p id="coordinates"></p>

<p id="demo"></p>

<h1>My First Google Map</h1>

<div id="map" style="width:100%;height:500px;"></div>



<script>
    var x = document.getElementById("coordinates");
    var lati;
    var lonti;

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        lati = position.coords.latitude;
        lonti = position.coords.longitude;
        x.innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude;

        var myLatLng = {lat: this.lati, lng: this.lonti};

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
        });
    }


    /////// google api

    // function initMap() {
    //     var myLatLng = {lat: this.lati, lng: this.lonti};
    //
    //     var map = new google.maps.Map(document.getElementById('map'), {
    //         zoom: 15,
    //         center: myLatLng
    //     });
    //
    //     var marker = new google.maps.Marker({
    //         position: myLatLng,
    //         map: map,
    //         title: 'Hello World!'
    //     });
    // }


</script>


<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk&callback=initMap">
</script>

</body>
</html>