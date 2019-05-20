@extends('layouts.header')
@section('title','หน้าแรก')
@section('content')

    <div class="container-fluid" style="margin-bottom: 300px">
        <div class="shadow bg-white rounded">
            <div class="card intable cardColor cardStyleMargin" style="padding-bottom: 100px">
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators2" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators2" data-slide-to="1"></li>
{{--                        <li data-target="#carouselExampleIndicators2" data-slide-to="2"></li>--}}
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="img-fluid" src="{{asset('images/slide/slide_img.jpg')}}" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="img-fluid" src="{{asset('images/slide/slide_img2.jpg')}}" alt="Second slide">
                        </div>
{{--                        <div class="carousel-item">--}}
{{--                            <img class="img-fluid" src="../../assets/images/big/img5.jpg" alt="Third slide">--}}
{{--                        </div>--}}
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">ก่อนหน้า</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">ถัดไป</span>
                    </a>
                </div>
                <span class="mt-4 mb-2"><h2><span style="color: #df3031">ค้นหา</span>บริการรถยนต์ <small style="font-size: 18px">Search Car Service in Handy</small></h2></span>
                <form action="{{route('shop.search')}}" method="get">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-5 col-12 inputField">
                            <input type="search" class="form-control" id="inputName" name="inputName" placeholder="ค้นหาอู่">
                        </div>
                        <div id="typeDiv" class="col-md-4 col-12 inputField">
                            <select id="inputType" class="form-control" name="inputType">
                                <option value="" selected disabled>ประเภท</option>
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
                        <div id="insuranceDiv" class="col-md-2 col-12 inputField" style="display: none">
                            <select id="inputInsurance" class="form-control" name="inputInsurance">
                                <option value="" selected disabled>ประกันภัย</option>
                                @foreach ($insurances as $insurance)
                                    <option value="{{$insurance->type_id}}">{{$insurance->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-12 inputField">
                            <select id="inputRange" class="form-control" name="inputRange">
                                <option value="0" selected>ไม่จำกัด</option>
                                <option value="3000">3 กิโลเมตร</option>
                                <option value="5000">5 กิโลเมตร</option>
                                <option value="8000">8 กิโลเมตร</option>
                                <option value="10000">10 กิโลเมตร</option>
                            </select>
                        </div>
                        <div class="col-md-1 col-12 inputField text-right">
                            <input type="hidden" id="inputLat" name="inputLat" value="">
                            <input type="hidden" id="inputLng" name="inputLng" value="">
                            <button type="submit" class="btn waves-effect waves-light btn-danger btn-block" value="Submit" id="btnSubmit" onclick="return confirmSearch()" disabled>รอสักครู่...</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('script')
{{--    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk"></script>--}}
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk&libraries=places"></script>
    <script>

        $(document).ready(function () {
            getLocation();

            $('#inputType').on('change',function () {
                let choose = $('#inputType option:selected').val();
                if (choose === 'typeInsure'){
                    $('#typeDiv').removeClass('col-md-4');
                    $('#typeDiv').addClass('col-md-2');
                    $('#insuranceDiv').fadeIn('slow');
                }else{
                    $('#insuranceDiv').hide();
                    $('#inputInsurance').val("");
                    $('#typeDiv').removeClass('col-md-2');
                    $('#typeDiv').addClass('col-md-4');
                }
            })
        });

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
            var lng = position.coords.longitude;
            console.log(lat);
            console.log(lng);
            $('#inputLat').val(lat);
            $('#inputLng').val(lng);
            $('#btnSubmit').empty();
            $('#btnSubmit').append("<i class=\"fas fa-search\"></i>");
            $('#btnSubmit').prop('disabled',false);
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

        function confirmSearch() {
            let name = $('#inputName').val();
            let type = $('#inputType').val();
            let insurance = $('#inputInsurance').val();
            let range = $('#inputRange').val();
            if (name === '' && type == null && insurance == null && range === '0'){
                Swal.fire({
                    type: 'warning',
                    title: 'กรุณาใส่ข้อมูลค้นหา!',
                });
                return false;
            }
            if (type === 'typeInsure'){
                $('#inputType').val('');
                if (insurance != null){
                    $.blockUI({ message: null});
                    return true
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'กรุณาเลือกประกันภัย!',
                    });
                    return false;
                }
            }
            $.blockUI({ message: null});
            return true;
        }

    </script>
@stop