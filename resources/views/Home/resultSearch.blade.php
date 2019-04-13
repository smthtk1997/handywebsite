@extends('layouts.header')
@section('title','การค้นหา')
@section('content')
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="shadow bg-white rounded">
            <div class="card intable cardColor cardStyleMargin" style="padding-bottom: 100px">
                <h3>การค้นหา:</h3>
                <div class="row mb-3">
                    @if (!empty($nameSearch))
                        <div class="col-4 col-md-3 col-lg-2 d-flex align-items-stretch">
                            <div class="badge searchInfo">คำค้นหา: {{$nameSearch}}</div>
                        </div>
                    @endif
                    @if (!empty($type))
                        <div class="col-4 col-md-3 col-lg-2 d-flex align-items-stretch">
                            <div class="badge searchInfo">ประเภท: {{$type}}</div>
                        </div>
                    @endif
                    @if ($range == 0)
                        <div class="col-4 col-md-3 col-lg-2 d-flex align-items-stretch">
                            <div class="badge searchInfo">ในระยะ: ไม่จำกัด</div>
                        </div>
                    @else
                        <div class="col-4 col-md-3 col-lg-2 d-flex align-items-stretch">
                            <div class="badge searchInfo">ในระยะ: {{$range/1000}} กิโลเมตร</div>
                        </div>
                    @endif
                </div>
                <div id="map"></div>
                <div id="load" class="i-am-centered">
                    <img src="{{asset('images/Magnify.svg')}}" alt="loadingSVG">
                </div>
                <div>
                    @for ($i = 0; $i < sizeof($results); $i++)
                        <img src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={{$results[$i][5]}}&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk" alt="img">
                    @endfor
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk&libraries=places"></script>
    <script type="text/javascript">

        var userLat = {{ $lat }};
        var userLng = {{ $lng }};
        var userMarker;

        $(document).ready(function () {
           getPlace()
        });

        function getPlace() {
            var locations = {!!  json_encode($results); !!};
            var iconUser = {
                url: '{{ URL::asset('images/MapPointer/place_user.png') }}', // url
                scaledSize: new google.maps.Size(38, 38), // scaled size
            };

            var iconPlace = {
                url: '{{ URL::asset('images/MapPointer/place_star.png') }}', // url
                scaledSize: new google.maps.Size(38, 38), // scaled size
            };

            var mapholder = document.getElementById('map');
            mapholder.style.height = '500px';
            mapholder.style.width = 'auto';

            var myOptions = {
                zoom: 14,
                center: new google.maps.LatLng(userLat, userLng),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
            };

            var map = new google.maps.Map(document.getElementById("map"), myOptions);
            $('#load').fadeOut('slow');

            userMarker = new google.maps.Marker({
                position: new google.maps.LatLng(userLat,userLng),
                map: map,
                title: "You are here!",
                icon: iconUser,
                animation: google.maps.Animation.BOUNCE
            });


            var contentString = '<div id="content">'+
                '<div id="siteNotice">'+
                '</div>'+
                '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
                '<div id="bodyContent">'+
                '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
                'sandstone rock formation in the southern part of the '+
                'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
                'south west of the nearest large town, Alice Springs; 450&#160;km '+
                '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
                'features of the Uluru - Kata Tjuta National Park. Uluru is '+
                'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
                'Aboriginal people of the area. It has many springs, waterholes, '+
                'rock caves and ancient paintings. Uluru is listed as a World '+
                'Heritage Site.</p>'+
                '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
                'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
                '(last visited June 22, 2009).</p>'+
                '</div>'+
                '</div>';



            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: iconPlace
                });


                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]+" | Address : "+locations[i][3]+" | Rating : "+locations[i][4].toString()+' <button  class="btn btn-outline-danger btn-sm">More Detail</button >');
                        infowindow.open(map, marker);
                        if (marker.getAnimation() !== null){
                            marker.setAnimation(null);
                        }else{
                            marker.setAnimation(google.maps.Animation.BOUNCE);
                            setTimeout(function () {
                                marker.setAnimation(null);},2150);
                        }
                    }
                })(marker, i));
            }
        }
    </script>

@stop