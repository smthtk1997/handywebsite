@extends('users.header')
@section('title','Handy Driver Assist')
@section('content')

    <div class="container-fluid">
        <div>
            <a onclick="onShow()" class="btn btn-success mt-3" id="answerbtn" style="display: none;color: whitesmoke">Show</a>
        </div>

        <p id="demo"></p>

        <h1>See you location in map!</h1>

        <div id="mapholder"></div>

        <br>

        <div id="load" class="i-am-centered">
            <img src="{{asset('images/Magnify.svg')}}" alt="loadingSVG">
        </div>


        <h1 style="border-bottom: #fd5c5c solid 2px;margin-bottom: 20px">Store</h1>

        <div>
            @foreach($data as $row)
            {{$row['id']}}
            <br>"
            {{$row['formatted_address']}}
            <br>
            {{$row['name']}}
            <br>
            {{$row['geometry']['location']['lat']}}
            <br>
            {{$row['geometry']['location']['lng']}}
            <br>
            <hr>
            @endforeach
        </div>
    </div>


    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk&libraries=places"></script>
    <script>

        $(document).ready(function () {
            getLocation()
        });


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
            $('#load').fadeOut('slow');
            $('#answerbtn').slideDown('slow');
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            latitude = position.coords.latitude;
            longtitude = position.coords.longitude;
            // document.getElementById("lat").innerHTML = 'Latitude : =' + latitude;
            // document.getElementById("lon").innerHTML = 'Longitude : =' + longtitude;
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

@stop

@section('script')
@stop