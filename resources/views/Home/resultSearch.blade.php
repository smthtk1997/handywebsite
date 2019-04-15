@extends('layouts.header')
@section('title','การค้นหา')
@section('content')
    <div class="container-fluid">
        <div class="shadow bg-white rounded">
            <div class="card intable cardColor cardStyleMargin" style="padding-bottom: 100px">
                <h3>การค้นหา</h3>
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
                <div style="margin-top: 2.5rem">
                    <h3 style="margin-bottom: 2.5rem">ผลลัพธ์การค้นหา</h3>
                    <ul class="list-unstyled m-t-40">
                        @for ($i = 0; $i < sizeof($results); $i++)
                            <li class="media">
                                <img class="image-popup-vertical-fit" href="https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&photoreference={{$results[$i][5]}}&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk"
                                     src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=200&photoreference={{$results[$i][5]}}&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk"
                                     width="200" style="max-height: 200px;max-width: 200px;margin-right: 20px;"
                                     alt="Generic placeholder image">

                                <div class="media-body">
                                    <h4 class="mb-2">{{$results[$i][0]}}</h4>
                                    <p style="margin-bottom: 0.25rem;font-size: 15px">ที่อยู่: {{$results[$i][3]}}</p>
                                    <p style="margin-bottom: 0.25rem;font-size: 15px">
                                        คะแนนจากเว็บ: {{$results[$i][4]}}</p>
                                    @if ($results[$i][6] != null)
                                        <a href="tel:{{$results[$i][6]}}" style="font-size: 15px">โทร: {{str_replace('+66-','0',$results[$i][6])}}</a>
                                    @endif
                                    <div class="mt-2">
                                        <a href="{{$results[$i][7]}}"
                                           class="btn btn-danger waves-effect waves-light btn-sm"
                                           target="_blank">กดเพื่อนำทาง</a>
                                    </div>
                                </div>
                            </li>
                            <hr>
                        @endfor
                    </ul>
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
            getPlace();
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
                navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}
            };

            var map = new google.maps.Map(document.getElementById("map"), myOptions);

            userMarker = new google.maps.Marker({
                position: new google.maps.LatLng(userLat, userLng),
                map: map,
                title: "You are here!",
                icon: iconUser,
                animation: google.maps.Animation.BOUNCE
            });


            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: iconPlace
                });


                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent("<div id='content' style='padding: 5px'>\n" +
                            "        <h4 id='firstHeading' class='firstHeading'>"+locations[i][0]+"</h4>\n" +
                            "\n" +
                            "        <div id=\"bodyContent\">\n" +
                            "            <p style=\"margin-bottom: 0.25rem;font-size: 15px\">\n" +
                            "                ที่อยู่: "+locations[i][3]+"\n" +
                            "            </p>\n" +
                            "            <p style=\"margin-bottom: 0.25rem;font-size: 15px\">\n" +
                            "                คะแนนจากเว็บ: "+locations[i][4].toString()+"\n" +
                            "            </p>\n" +
                            "            <a href='"+locations[i][6]+"' style=\"font-size: 15px\">โทร: "+locations[i][6]+"</a>\n" +

                            "            <div style=\"top: 10px;\"><a href='"+locations[i][7]+"' class=\"btn btn-googleplus waves-light waves-effect btn-sm float-right\" target='_blank'>นำทาง</a></div>\n" +
                            "        </div>\n" +
                            "\n" +
                            "    </div>");
                        infowindow.open(map, marker);
                        if (marker.getAnimation() !== null) {
                            marker.setAnimation(null);
                        } else {
                            marker.setAnimation(google.maps.Animation.BOUNCE);
                            setTimeout(function () {
                                marker.setAnimation(null);
                            }, 2150);
                        }
                    }
                })(marker, i));
            }
        }
    </script>

@stop