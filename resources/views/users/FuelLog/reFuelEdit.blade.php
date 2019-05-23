@extends('layouts.header')
@section('title','แก้ไขการเติมน้ำมัน')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_red.css">
    <style>
        .founded{
            border: solid 1px #44bd32;
        }
    </style>

@stop
@php
    $stations = ['ปตท.','เชลล์','บางจาก','เอสโซ่','คาลเท็กซ์','พีที','ซัสโก้','อื่นๆ'];
@endphp
@php
    $fuel_types = ['ดีเซล','ดีเซลพรีเมี่ยม','เบนซิน-95','แก๊สโซฮอล์-95','แก๊สโซฮอล์-91','แก๊สโซฮอล์-E20','แก๊สโซฮอล์-E85'];
@endphp
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">แก้ไขการเติมน้ำมัน</h3>
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
                            <li class="breadcrumb-item active">แก้ไขการเติมน้ำมัน</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-bottom: 300px">
        <div class="shadow bg-white rounded">
            <div class="card intable cardColor cardStyleMargin" style="padding-bottom: 100px">
                <div id="map" style="margin-bottom: 10px;display: none"></div>
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
                <form action="{{route('fuellog.myLog.refuel.update',['log'=>$log->token])}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            <label for="selectorDate">วันที่เติม</label>
                            <input id="selectorDate" class="flatpickr flatpickr-input  form-control"
                                   type="text" name="selectorDate">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="selectorTime">เวลาที่เติม</label>
                            <input id="selectorTime" class="flatpickr flatpickr-input  form-control"
                                   type="text" name="selectorTime">
                        </div>
                        <div class="form-group col-12 col-md-4 mt-md-4 mt-0">
                            <button type="button" id="date_now" class="btn btn-outline-info waves-effect waves-light btn-block" style="margin-top: 0.3rem">ตอนนี้</button>
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="mileage">ระยะทางรวม (กิโลเมตร)</label>
                            <input type="number" min="0" max="999999" id="mileage" class="form-control" value="{{$log->mileage}}" name="mileage">
                            @if ($log->get_car)
                                <small class="text-muted">ระยะทางรวมล่าสุด: {{number_format($log->get_car->mileage)}} กิโลเมตร</small>
                            @endif
                        </div>
                        <div class="col-12 col-md-4" style="margin-top: 0.25rem;">
                            <label for="gas_station">ปั้มน้ำมัน</label>
                            <select id="gas_station" class="form-control" name="gas_station">
                                @foreach ($stations as $station)
                                    @if ($station == $log->gas_station)
                                        <option value="{{$station}}" selected>{{$station}}</option>
                                        @else
                                        <option value="{{$station}}">{{$station}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4" style="margin-top: 0.25rem;">
                            <label for="fuel_type">ประเภทน้ำมัน</label>
                            <select id="fuel_type" class="form-control" name="fuel_type">
                                <option value="" selected disabled>เลือกประเภทน้ำมัน</option>
                                @foreach ($fuel_types as $fuel)
                                    @if ($fuel == $log->fuel_type)
                                        <option value="{{$fuel}}" selected>{{$fuel}}</option>
                                    @else
                                        <option value="{{$fuel}}">{{$fuel}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="price_liter">ราคา/ลิตร</label>
                            <input type="number" step="any" id="price_liter" class="form-control" value="{{$log->price_liter}}" name="price_liter">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="total_price">ราคารวม</label>
                            <input type="number" step="any" id="total_price" class="form-control" value="{{$log->total_price}}" name="total_price">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="total_liter">จำนวนลิตร</label>
                            <input type="number" step="any" id="total_liter" class="form-control" value="{{$log->total_liter}}" name="total_liter">
                        </div>
                    </div>
                    <div class="form-row" style="margin-top: 10px">
                        <div class="form-group col-4">
                            <input type="button" class="btn btn-danger btn-lg float-left" value="ล้างค่า" id="btnReset" onclick="window.location.reload()">
                        </div>

                        <div class="form-group col-4 text-center"></div>

                        <div class="form-group col-4">
                            <input type="submit" class="btn btn-success btn-lg float-right" value="ยืนยัน" id="btnSubmit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@stop

@section('script')
    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        var price_liter;
        var total_price;
        var total_liter;
        var gas_station;
        $(document).ready(function () {
            let date = new Date();
            let hour = date.getHours();
            let minute = date.getMinutes();

            let last_date = new Date('{{\Carbon\Carbon::parse($log->filling_date)}}');
            let last_time = new Date('{{\Carbon\Carbon::parse($log->filling_time)}}');



            $("#selectorDate").flatpickr({
                dateFormat: "d/m/y",
                mode: 'single',
                defaultDate: 'today',
                maxDate: "today",
                time_24hr: false,
                disableMobile: "true",
            });

            $("#selectorTime").flatpickr({
                enableTime: true,
                noCalendar: true,
                time_24hr: true,
                minuteIncrement: 1,
                enableSeconds: true,
                disableMobile: "true",
            });

            $("#selectorDate").val(last_date.getDate()+"/"+(parseInt(last_date.getMonth()+1))+"/"+last_date.getFullYear());
            $('#selectorTime').val(last_time.getHours()+":"+last_time.getMinutes()+":"+last_time.getSeconds());

            gas_station = $('#gas_station option:selected').val();

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
                    });
                    $('#fuel_type').val('');
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
                        });
                        $('#fuel_type').val('');
                    }
                }else{
                    Swal.fire({
                        type: 'error',
                        title: 'ไม่พบข้อมูล!',
                        text: 'กรุณาลองอีกครั้ง',
                    });
                    $('#fuel_type').val('');
                }
            });
        }


    </script>
@stop