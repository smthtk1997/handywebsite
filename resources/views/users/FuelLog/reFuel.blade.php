@extends('layouts.header')
@section('title','เติมน้ำมัน')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_red.css">
    <style>
        .founded{
            border: solid 1px #44bd32;
        }
    </style>

@stop
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">เติมน้ำมัน</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('fuellog.app.index')}}">myFuelLog</a>
                            </li>
                            <li class="breadcrumb-item active">เติมน้ำมัน</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-bottom: 300px">
        <div class="shadow bg-white rounded">
            <div class="card intable cardColor cardStyleMargin" style="padding-bottom: 100px">
                <div class="i-am-centered" id="loadingRadio" style="margin-bottom: 20px">
                    <img class="loading text-center"  src="{{asset('images/Radio-1s-200px.svg')}}" alt="" height="120px"><br>
                    <small class="text-danger">กำลังค้นหาสัญญาณ GPS</small>
                </div>
                <div id="map" style="margin-bottom: 10px;display: none"></div>
                <hr style="margin-bottom: 25px">
                @if ($errors->any())
                    <div class="">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{route('fuellog.myLog.refuel.save',['car'=>$car->token])}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            <label for="slip_img">อ่านค่าจากใบเสร็จ</label>
                            <div class="custom-file">
                                <input type="file" accept="image/*" class="custom-file-input" name="slip_img" id="slip_img" data-toggle="tooltip" data-placement="bottom" title="อัพโหลดรูปใบเสร็จ" onchange="$(this).next().after().text($(this).val().split('\\').slice(-1)[0])">
                                <label class="custom-file-label" for="slip_img" style="font-weight: normal">เลือกไฟล์</label>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="selectorDate">วันที่เติม</label>
                            <input id="selectorDate" class="flatpickr flatpickr-input  form-control"
                                   type="text" name="selectorDate">
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="selectorTime">เวลาที่เติม</label>
                            <input id="selectorTime" class="flatpickr flatpickr-input  form-control"
                                   type="text" name="selectorTime">
                        </div>
                        <div class="form-group col-12 col-md-2 mt-md-4 mt-0">
                            <button type="button" id="date_now" class="btn btn-outline-info waves-effect waves-light btn-block" style="margin-top: 0.3rem">ตอนนี้</button>
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="mileage">ระยะทางรวม (กิโลเมตร)</label>
                            <input type="number" id="mileage" class="form-control" placeholder="ระยะทางรวม" name="mileage">
                            <small class="text-muted">ระยะทางรวมล่าสุด: {{$last_refuel->mileage}}</small>
                        </div>
                        <div class="col-12 col-md-4" style="margin-top: 0.25rem;">
                            <label for="gas_station">ปั้มน้ำมัน</label>
                            <select id="gas_station" class="form-control" name="gas_station">
                                <option value="" selected disabled>เลือกปั้มน้ำมัน</option>
                                <option value="ปตท.">ปตท.</option>
                                <option value="เชลล์">เชลล์</option>
                                <option value="บางจาก">บางจาก</option>
                                <option value="เอสโซ่">เอสโซ่</option>
                                <option value="คาลเท็กซ์">คาลเท็กซ์</option>
                                <option value="พีที">พีที</option>
                                <option value="ซัสโก้">ซัสโก้</option>
                                <option value="อื่นๆ">อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4" style="margin-top: 0.25rem;">
                            <label for="fuel_type">ประเภทน้ำมัน</label>
                            <select id="fuel_type" class="form-control" name="fuel_type">
                                <option value="" selected disabled>เลือกประเภทน้ำมัน</option>
                                <option value="ดีเซล">ดีเซล</option>
                                <option value="ดีเซลพรีเมี่ยม">ดีเซลพรีเมี่ยม</option>
                                <option value="เบนซิน-95">เบนซิน-95</option>
                                <option value="แก๊สโซฮอล์-95">แก๊สโซฮอล์-95</option>
                                <option value="แก๊สโซฮอล์-91">แก๊สโซฮอล์-91</option>
                                <option value="แก๊สโซฮอล์-E20">แก๊สโซฮอล์-E20</option>
                                <option value="แก๊สโซฮอล์-E85">แก๊สโซฮอล์-E85</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="price_liter">ราคา/ลิตร</label>
                            <input type="number" step="any" id="price_liter" class="form-control" placeholder="ราคาต่อลิตร" name="price_liter">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="total_price">ราคารวม</label>
                            <input type="number" step="any" id="total_price" class="form-control" placeholder="ราคารวม" name="total_price">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="total_liter">จำนวนลิตร</label>
                            <input type="number" step="any" id="total_liter" class="form-control" placeholder="จำนวนลิตร" name="total_liter">
                        </div>
                    </div>
                    <div class="form-row" style="margin-top: 10px">
                        <div class="form-group col-4">
                            <input type="button" class="btn btn-danger btn-lg float-left" value="ล้างค่า" id="btnReset" onclick="window.location.reload()">
                        </div>

                        <div class="form-group col-4 text-center"></div>

                        <div class="form-group col-4">
                            <input type="submit" class="btn btn-success btn-lg float-right" value="ยืนยัน" id="btnSubmit" disabled onclick="return check()">
                        </div>
                    </div>
                    <input type="hidden" name="user_lat" id="user_lat">
                    <input type="hidden" name="user_lng" id="user_lng">
                </form>
            </div>
        </div>
    </div>


@stop

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk&libraries=places"></script>
    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        var userLat;
        var userLng;
        var userMarker;
        var price_liter;
        var total_price;
        var total_liter;
        var gas_station;
        $(document).ready(function () {
            getLocation();
            let date = new Date();
            let hour = date.getHours();
            let minute = date.getMinutes();
            $("#selectorDate").flatpickr({
                dateFormat: "d/m/y",
                mode: 'single',
                defaultDate: 'today',
                maxDate: "today",
                time_24hr: false,
            });

            $('#selectorTime').val(hour+":"+minute);

            $("#selectorTime").flatpickr({
                enableTime: true,
                noCalendar: true,
                time_24hr: true,
                minuteIncrement: 1,
                enableSeconds: true
            });

            $('#date_now').on('click tap',function () {
                let now_date = '{{\Carbon\Carbon::now()->format('d/m/y')}}';
                let time = '{{\Carbon\Carbon::now()->format('H:i:s')}}';
                $('#selectorDate').val(now_date);
                $('#selectorTime').val(time);
            });

            $('#gas_station').on('change',function () {
                gas_station = $('#gas_station option:selected').val();
            });

            $('#fuel_type').on('change',function () {
               let type = $('#fuel_type option:selected').val();
               if (type !== '' && gas_station !== '' && gas_station){
                   fuelPrice(gas_station,type);
                   $.blockUI({ message: null});
               }else{
                   Swal.fire({
                       type: 'warning',
                       title: 'กรุณาเลือกปั้มน้ำมันก่อน!',
                       timer:2000,
                       showConfirmButton: false

                   })
               }
            });

            $('#price_liter').on('keyup keydown change',function () {
                price_liter = $(this).val();
                
                if (total_price){
                    let total_price_in = total_price / price_liter;
                    if (total_price_in > 0){
                        $('#total_liter').val(total_price_in.toFixed(2));
                    }
                }else if (total_liter){
                    let total_price_in = price_liter * total_liter;
                    if (total_price_in > 0){
                        $('#total_price').val(total_price_in.toFixed(2));
                    }
                }
            });

            $('#total_price').on('keyup keydown change',function () {
                total_price = $(this).val();
                
                if (price_liter){
                    let total_liter_in = total_price / price_liter;
                    if (total_liter_in > 0){
                        $('#total_liter').val(total_liter_in.toFixed(2));
                    }
                }else if (total_liter){
                    let price_liter_in = total_price / total_liter;
                    if (price_liter_in > 0){
                        $('#price_liter').val(price_liter_in.toFixed(2));
                    }
                }

            });

            $('#total_liter').on('keyup keydown change',function () {
                total_liter = $(this).val();

                if (total_price){
                    let price_liter_in = total_price / total_liter;
                    if (price_liter_in > 0){
                        $('#price_liter').val(price_liter_in.toFixed(2));
                    }
                }else if (price_liter){
                    let total_price_in = total_liter * price_liter;
                    if (total_price_in > 0){
                        $('#total_price').val(total_price_in.toFixed(2));
                    }
                }
            });


            $("#slip_img").change(function() {
                var file = document.getElementById('slip_img').files;
                if (file.length > 0) {
                    getBase64(file[0]);
                    $.blockUI({ message: null});
                }
            });


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
            $('#btnSubmit').prop('disabled',false);
            userLat = lat;
            userLng = lng;
            $('#user_lat').val(userLat);
            $('#user_lng').val(userLng);
            $('#loadingRadio').fadeOut('fast');
            showMap();
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

        function showMap() {
            var iconUser = {
                url: '{{ URL::asset('images/MapPointer/place_user.png') }}', // url
                scaledSize: new google.maps.Size(38, 38), // scaled size
            };


            var mapholder = document.getElementById('map');
            mapholder.style.height = '300px';
            mapholder.style.width = 'auto';

            var myOptions = {
                zoom: 14,
                center: new google.maps.LatLng(userLat, userLng),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
            };

            var map = new google.maps.Map(document.getElementById("map"), myOptions);

            userMarker = new google.maps.Marker({
                position: new google.maps.LatLng(userLat,userLng),
                map: map,
                title: "You are here!",
                icon: iconUser,
                animation: google.maps.Animation.BOUNCE
            });
            $('#map').fadeIn('slow');
        }

        function fuelPrice(station,type) {
            let path_url = null;
            if (gas_station === 'เชลล์'){
                path_url = '{{url('/api/fuel/shell/price.api')}}';
            }else{
                path_url = '{{route('api.fuel.ptt.price')}}';
            }
            $.ajax({
                url: path_url,
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {fuel_type: type,station: station}
            }).done(function (msg) {
                let data = JSON.parse(JSON.parse(JSON.stringify(msg)));
                $.unblockUI();
                if (data.status === true) {
                    if (data.price !== 'none'){
                        price_liter = data.price;

                        $('#price_liter').val(data.price);

                        if (total_price !== '' || total_price) {
                            let total_liter_in = total_price / price_liter;
                            if (total_liter_in > 0) {
                                $('#total_liter').val(total_liter_in.toFixed(2));
                            }
                        }
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'ไม่พบข้อมูล!',
                            text: 'เนื่องจากปั้มไม่มีน้ำมันประเภทนี้',
                        })
                    }
                }else{
                    Swal.fire({
                        type: 'error',
                        title: 'ไม่พบข้อมูล!',
                        text: 'กรุณาลองอีกครั้ง',
                    })
                }
            });
        }


        function getBase64(file) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {

                // $('#preview').attr('src',reader.result);
                var base64 = reader.result.replace("jpeg","png");
                base64 = base64.substr(22);
                var b = JSON.stringify({   "requests": [     {       "image": {         "content": base64       },       "features": [         {           "type": "TEXT_DETECTION"         }       ]     }   ] });
                var e = new XMLHttpRequest;
                e.onload=function(){
                    console.log(e.responseText);
                    //$('#respones').text(e.responseText);
                    var parsed = JSON.parse(e.responseText);
                    var allDesc = parsed["responses"][0]["textAnnotations"];
                    // $('#query').text(allDesc[0]["description"]);

                    // for each
                    var iFoundIt_price = -1;
                    var iFoundIt_date = -1;
                    var iFoundIt_time = -1;
                    for (var i in allDesc) {
                        let string = allDesc[i]["description"];
                        if (string.indexOf("THB") != -1){
                            iFoundIt_price = parseInt(i)+1;
                        }
                        if (string.indexOf("DATE") != -1){
                            iFoundIt_date = parseInt(i)+1;
                        }
                        if (string.indexOf("TIME") != -1){
                            iFoundIt_time = parseInt(i)+1;
                        }
                    }

                    if(iFoundIt_price !== -1){
                        console.log(allDesc[iFoundIt_price]["description"] + ' price');
                        let price = allDesc[iFoundIt_price]["description"];
                        let total_price_input = $('#total_price');
                        total_price = price;
                        total_price_input.addClass('founded');
                        total_price_input.val(price);

                        if (price_liter){
                            let total_liter_in = total_price / price_liter;
                            if (total_liter_in > 0) {
                                $('#total_liter').val(total_liter_in.toFixed(2));
                            }
                        }
                    }
                    if(iFoundIt_date !== -1){
                        console.log(allDesc[iFoundIt_date]["description"] + ' date');
                        let date = allDesc[iFoundIt_date]["description"];
                        let selector_Date_input = $('#selectorDate');
                        selector_Date_input.addClass('founded');
                        selector_Date_input.val(date);
                    }
                    if(iFoundIt_time !== -1){
                        console.log(allDesc[iFoundIt_time]["description"] + ' time');
                        let time = allDesc[iFoundIt_time]["description"];
                        let selector_Time_input = $('#selectorTime');
                        selector_Time_input.addClass('founded');
                        selector_Time_input.val(time);
                    }
                    if (iFoundIt_price === -1 && iFoundIt_date === -1 && iFoundIt_time === -1){
                        Swal.fire({
                            type: 'warning',
                            title: 'ไม่พบข้อมูล!',
                            text: 'กรุณาเพิ่มข้อมูลด้วยตนเอง',
                        })
                    }
                    $.unblockUI();

                };
                e.open("POST","https://vision.googleapis.com/v1/images:annotate?key=AIzaSyDojrPs_7996MrPXVnG-TuC2d2Rjex08hI",!0);
                e.send(b)


            };
            reader.onerror = function (error) {
                console.log('Error: ', error);
            };
        }

        function check() {
            let mile = $('#mileage').val();
            let old_mile = '{!! $last_refuel->mileage !!}';

            if (mile >= old_mile){
                $.blockUI({ message: null});
                return true
            }else{
                Swal.fire({
                    type: 'warning',
                    title: 'ระยะทางรวมน้อยกว่าครั้งก่อน!',
                    text: 'กรุณาใส่ระยะทางรวมใหม่',
                });
                return false;
            }
        }


    </script>
@stop