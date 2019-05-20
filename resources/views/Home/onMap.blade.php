@extends('layouts.header')
@section('title','การค้นหา')
@section('style')
    <link href="{{asset('libs/magnific-popup/dist/magnific-popup.css')}}" rel="stylesheet">
    <style>


    </style>
@stop
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">การค้นหา</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item active">ค้นหาบนแผนที่</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid containerStyle">
        <div class="shadow bg-white rounded">
            <div class="card intable" style="padding-bottom: 100px">
                <h3 style="margin-bottom: 20px">เลื่อนแผนที่เพื่อค้นหาร้าน</h3>
                <div class="i-am-centered" id="loadingRadio" style="margin-bottom: 20px">
                    <img class="loading text-center"  src="{{asset('images/Radio-1s-200px.svg')}}" alt="" height="120px"><br>
                    <small class="text-danger">กำลังค้นหาสัญญาณ GPS</small>
                </div>
                <div id="map" style="display: none"></div>
                <h4 style="margin-top: 20px">เลือกตามประเภท</h4>
                <div class="row">
                    <div id="typeDiv" class="col-md-12 col-12 inputField">
                        <select id="inputType" class="form-control" name="inputType" disabled>
                            <option value="all" selected>ทุกประเภท</option>
                            <option value="6">อู่ซ่อมรถยนต์</option>
                            <option value="1">ศูนย์รถยนต์</option>
                            <option value="typeInsure">ในเครือประกันภัย</option>
                            <option value="8">ล้างรถ-เคลือบสี</option>
                            <option value="5">ปั้มน้ำมัน</option>
                            <option value="15">ยาง และ ล้อแม็ก</option>
                            <option value="16">เครื่องเสียง</option>
                            <option value="17">ประดับยนต์</option>
                            <option value="9">บริการเช่ารถ</option>
                        </select>
                    </div>
                    <div id="insuranceDiv" class="col-md-6 col-12 inputField" style="display: none">
                        <select id="inputInsurance" class="form-control" name="inputInsurance">
                            <option value="" selected disabled>ประกันภัย</option>
                            @foreach ($insurances as $insurance)
                                <option value="{{$insurance->type_id}}">{{$insurance->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('libs/magnific-popup/dist/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('libs/magnific-popup/meg.init.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk&libraries=places"></script>
    <script type="text/javascript">

        var userLat;
        var userLng;
        var userMarker;
        var map;
        var placeMarker;
        var marker_inmap, i_lap;
        var marker_array = [];
        var nord;
        var est;
        var sud;
        var ovest;

        var type;
        var insurance;

        $(document).ready(function () {
            getLocation();

            type = null;
            insurance = null;

            $('#inputType').on('change',function () {
                let choose = $('#inputType option:selected').val();

                if (choose === 'typeInsure'){
                    $('#typeDiv').removeClass('col-md-12');
                    $('#typeDiv').addClass('col-md-6');
                    $('#insuranceDiv').fadeIn('slow');
                    type = $('#inputType option:selected').val();
                }
                else if (choose === 'all'){
                    $('#insuranceDiv').hide();
                    $('#inputInsurance').val("");
                    $('#typeDiv').removeClass('col-md-6');
                    $('#typeDiv').addClass('col-md-12');
                    type = null;
                    insurance = null;
                    apiAjax(nord,est,sud,ovest,type,insurance);

                }else{
                    $('#insuranceDiv').hide();
                    $('#inputInsurance').val("");
                    $('#typeDiv').removeClass('col-md-6');
                    $('#typeDiv').addClass('col-md-12');
                    insurance = null;
                    type = $('#inputType option:selected').val();
                    apiAjax(nord,est,sud,ovest,type,insurance);
                }
            });

            $('#inputInsurance').on('change',function () {
                insurance = $('#inputInsurance option:selected').val();
                apiAjax(nord,est,sud,ovest,type,insurance);
            })
        });


        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            userLat = lat;
            userLng = lng;
            console.log(lat);
            console.log(lng);
            getPlace();
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

        function getPlace() {
            var iconUser = {
                url: '{{ URL::asset('images/MapPointer/place_user.png') }}', // url marker user
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

            map = new google.maps.Map(document.getElementById("map"), myOptions);

            userMarker = new google.maps.Marker({
                position: new google.maps.LatLng(userLat, userLng),
                map: map,
                title: "คุณอยู่ที่นี่!",
                icon: iconUser,
                animation: google.maps.Animation.BOUNCE
            });

            $('#loadingRadio').fadeOut('fast');
            $('#map').fadeIn('slow');

            google.maps.event.addListener(map, 'idle', function() {
                nord  = map.getBounds().getNorthEast().lat();
                est   = map.getBounds().getNorthEast().lng();
                sud   = map.getBounds().getSouthWest().lat();
                ovest = map.getBounds().getSouthWest().lng();

                $('#inputType').prop('disabled',false);

                apiAjax(nord,est,sud,ovest,type,insurance);

                //$.blockUI({ message: null});
            });
        }

        function apiAjax(aNord,aEst,aSud,aOvest,type,insurance) {
            if (type != null){
                if (insurance == null){
                    if (type === 'typeInsure'){
                        Swal.fire({
                            type: 'warning',
                            title: 'กรุณาเลือกประกันภัย!',
                        });
                    }else{
                        $.ajax({
                            url: '{!! url('/api/map/type/bound.api') !!}',
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {aNord: aNord,aEst: aEst,aSud: aSud,aOvest: aOvest,type: type,insurance: insurance}
                        }).done(function (msg) {
                            let data = JSON.parse(JSON.parse(JSON.stringify(msg)));
                            if (data.status === true) {
                                setMarker(data.places);
                            }else{
                                removeMarker();
                            }
                        });
                    }
                }
                if (insurance != null){
                    $.ajax({
                        url: '{!! url('/api/map/type/bound.api') !!}',
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {aNord: aNord,aEst: aEst,aSud: aSud,aOvest: aOvest,type: type,insurance: insurance}
                    }).done(function (msg) {
                        let data = JSON.parse(JSON.parse(JSON.stringify(msg)));
                        if (data.status === true) {
                            setMarker(data.places);
                        }else{
                            removeMarker();
                        }
                    });
                }
            }else{
                $.ajax({
                    url: '{!! url('/api/map/bound.api') !!}',
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {aNord: aNord,aEst: aEst,aSud: aSud,aOvest: aOvest}
                }).done(function (msg) {
                    let data = JSON.parse(JSON.parse(JSON.stringify(msg)));
                    if (data.status === true) {
                        setMarker(data.places);
                    }else{
                        removeMarker();
                    }
                });
            }

        }

        function setMarker(place) {
            removeMarker();
            var locations = place;
            var iconPlace = {
                url: '{{ URL::asset('images/MapPointer/place_star.png') }}', // url marker place
                scaledSize: new google.maps.Size(38, 38), // scaled size
            };

            var infowindow = new google.maps.InfoWindow();

            var detail_path = '{!! url('/handy/shop/detail') !!}';


            for (i_lap = 0; i_lap < locations.length; i_lap++) {
                marker_inmap = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i_lap].lat, locations[i_lap].lng),
                    map: map,
                    icon: iconPlace
                });

                marker_array.push(marker_inmap);

                google.maps.event.addListener(marker_inmap, 'click', (function (marker_inmap, i) {
                    return function () {
                        infowindow.setContent("<div id='content' style='padding: 5px'>\n" +
                            "        <h4 id='firstHeading' class='firstHeading'>"+locations[i].name+"</h4>\n" +
                            "\n" +
                            "        <div id=\"bodyContent\">\n" +
                            "            <p style=\"margin-bottom: 0.25rem;font-size: 15px\">\n" +
                            "                ที่อยู่: "+locations[i].formatted_address+"\n" +
                            "            </p>\n" +
                            "            <p style=\"margin-bottom: 0.25rem;font-size: 15px\">\n" +
                            "                คะแนนจากเว็บ: "+locations[i].rating.toString()+"\n" +
                            "            </p>\n" +
                            "            <a href='tel:"+locations[i][6]+"' style=\"font-size: 15px\">โทร: "+locations[i].phone_number+"</a>\n" +

                            "            <div class='btn-group float-right mt-2 mt-md-0'>" +
                            "<a href='"+detail_path+"/"+locations[i].place_id+"' class=\"btn btn-info waves-light waves-effect btn-sm mr-2\" target='_blank'>ดูรายละเอียด</a>" +
                            "<a href='"+locations[i].url_nav+"' class=\"btn btn-googleplus waves-light waves-effect btn-sm\" target='_blank'>นำทาง</a>" +
                            "</div>\n" +
                            "        </div>\n" +
                            "\n" +
                            "    </div>");
                        infowindow.open(map, marker_inmap);
                        if (marker_inmap.getAnimation() !== null) {
                            marker_inmap.setAnimation(null);
                        } else {
                            marker_inmap.setAnimation(google.maps.Animation.BOUNCE);
                            setTimeout(function () {
                                marker_inmap.setAnimation(null);
                            }, 2150);
                        }
                    }
                })(marker_inmap, i_lap));

            }

            //$.unblockUI();
        }


        function removeMarker() {
            if (marker_array.length > 0) {
                for (var i=0; i<marker_array.length; i++) {
                    if (marker_array[i] != null) {
                        marker_array[i].setMap(null);
                    }
                }
            }
            marker_array = [];
        }
    </script>

@stop