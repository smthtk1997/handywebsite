@extends('layouts.header')
@section('title','เพิ่มรถคันใหม่')
@section('style')
    <style>

    </style>
@stop
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">เพิ่มรถคันใหม่</h3>
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
                            <li class="breadcrumb-item active">เพิ่มรถคันใหม่</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="margin-bottom: 300px">
        <div class="shadow bg-white rounded">
            <div class="card intable cardColor cardStyleMargin" style="padding-bottom: 100px">
                <h3>เพิ่มรถคันใหม่</h3>
                <hr>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">
                                        @if ($error == 'validation.without_spaces')
                                            ห้ามมีช่องว่างในช่องยี่ห้อ
                                        @else
                                            {{ $error }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @php
                        $rand = random_int(0,5);
                        $array_img = ['carBlue.png','carGreen.png','carHatch.png','carOrange.png','racing.png','suv.png']
                    @endphp
                    <div class="row">
                        <div class="col-12 col-md-4" id="display_img1" style="margin: auto;">
                            <div class="i-am-centered" style="margin-bottom: 30px;">
                                <img id="preview_img" class="centerOfRow rounded-circle" src="{{url('/files/user_car_img/'.$array_img[$rand])}}" alt="car_img" style="object-fit: cover;width: 200px;height: 200px;border-radius: 50%">
                                <img id="car_logo" class="centerOfRow" src="" alt="car_logo" style="width: auto;height: 70px;margin-top: 25px;display: none">
                            </div>
                        </div>
                        <div class="col-12 col-md-8" id="form_tag">
                            {!! Form::open(['method' => 'post','route'=>['fuellog.app.create.car.store'],'files' => true]) !!}
                            <div class="form-row" style="margin-bottom: 20px">
                                <div class="form-group col-12 col-md-6">
                                    <label for="carName">ชื่อรถ</label>
                                    <input type="text" id="carName" class="mt-1 mb-1 form-control" name="carName" placeholder="ชื่อ" required>
                                    <input type="hidden" name="no_img" value="{{$array_img[$rand]}}">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="carLicense">เลขทะเบียน</label>
                                    <input type="text" id="carLicense" class="mt-1 mb-1 form-control" name="carLicense" placeholder="เลขทะเบียน" required>
                                </div>
                                <div class="form-group col-12 col-md-6" style="margin-top: 0.25rem;">
                                    <label for="brand">ยี่ห้อรถ</label>
                                    <select id="brand" class="form-control" name="brand" required>
                                        <option value="" selected disabled>เลือกยี่ห้อ</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" data-img="{{$brand->img_logo}}" >{{ucfirst($brand->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="modelCar">รุ่นรถ</label>
                                    <input type="text" id="modelCar" class="mt-1 mb-1 form-control" name="modelCar" placeholder="รุ่น" required disabled>
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="milleage">ระยะทางรวม (กิโลเมตร)</label>
                                    <input type="number" min="0" max="999999" id="milleage" class="mt-1 mb-1 form-control" name="milleage" placeholder="ระยะทาง" required>
                                </div>


                                <div class="form-group col-12 col-md-6" style="margin-top: 0.25rem;">
                                    <label for="car_img">รูปภาพ <span class="text-danger" id="car_nickname"></span></label>
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" class="custom-file-input" name="car_img" id="car_img" data-toggle="tooltip" data-placement="bottom" title="อัพโหลดรูปรถของท่าน" onchange="$(this).next().after().text($(this).val().split('\\').slice(-1)[0])">
                                        <label class="custom-file-label" for="car_img" style="font-weight: normal">เลือกไฟล์</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-4">
                                    <input type="button" class="btn btn-danger btn-lg float-left" value="ล้างค่า" id="btnReset" onclick="window.location.reload()">
                                </div>

                                <div class="form-group col-4 text-center" style="margin-top: -35px">
                                    <img class="loading text-center" style="display: none" id="loading2" src="{{asset('images/loading.svg')}}" alt="" height="120px">
                                </div>

                                <div class="form-group col-4">
                                    <input type="submit" class="btn btn-success btn-lg float-right" value="ยืนยัน" id="btnSubmit" onclick="checkLoading()">
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('#carName').on('keyup',function () {
               let name = $(this).val();
               $('#car_nickname').text(name);
            });
            $('#brand').on('change',function () {
                if ($('#brand option:selected').val() != ''){
                    let brand_select = ($('#brand option:selected').attr('data-img'));
                    $('#modelCar').prop('disabled',false);
                    let pathimg = '{{ url('/files/brand_logo') }}'+"/"+brand_select;
                    $('#car_logo').attr('src',pathimg);
                    $('#car_logo').fadeIn('slow');
                }
            });

            $("#car_img").change(function() {
                readURL(this);
                if ($('#car_logo').attr('src') != '') {
                    $('#car_logo').fadeIn('slow');
                }
            });
        });

        function checkLoading() {
            let carName = $('#carName').val();
            let carLicense = $('#carLicense').val();
            let brand = $('#brand').val();
            let modelCar = $('#modelCar').val();
            let milleage = $('#milleage').val();
            if (carName == '' || carLicense == '' || brand == '' || modelCar == '' || milleage == ''){
                $('#loading2').hide();
            }else{
                $('#loading2').fadeIn('slow');
            }
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview_img').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@stop