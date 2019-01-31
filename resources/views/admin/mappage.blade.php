<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk&libraries=places"></script>
</head>
<body>

<p>Click the button to get your location.</p>

<button onclick="getLocation()" class="btn btn-outline-primary" style="margin-left: 10px">Try It</button>

<button class="btn btn-outline-success" onclick="onShow()">Click to open</button>


<p id="coordinates"></p>

<p id="demo"></p>

<h1>See you location in map!</h1>

<div id="mapholder"></div>

<br>

<p id="lat"></p>

<p id="lon"></p>






<script>

    var latitude;
    var longtitude;

    var x = document.getElementById("demo");
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        latitude = position.coords.latitude;
        longtitude = position.coords.longitude;
        document.getElementById("lat").innerHTML = 'Latitude : =' + latitude;
        document.getElementById("lon").innerHTML = 'Longitude : =' + longtitude;
        var latlon = new google.maps.LatLng(latitude, longtitude);
        var mapholder = document.getElementById('mapholder');
        mapholder.style.height = '500px';
        mapholder.style.width = 'auto';

        var myOptions = {
            center:latlon,zoom:14,
            mapTypeId:google.maps.MapTypeId.ROADMAP,
            mapTypeControl:false,
            navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
        };

        var map = new google.maps.Map(document.getElementById("mapholder"), myOptions);
        var marker = new google.maps.Marker({position:latlon,map:map,title:"You are here!"});
    }


    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                x.innerHTML = "User denied the request for Geolocation.";
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable.";
                break;
            case error.TIMEOUT:
                x.innerHTML = "The request to get user location timed out.";
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "An unknown error occurred.";
                break;
        }
    }

    function onShow() {
        return window.location.href = '/api/'+latitude+'/'+longtitude+'/';
    }


</script>

</body>
</html>



