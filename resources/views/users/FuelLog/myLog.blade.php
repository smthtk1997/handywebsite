@extends('layouts.header')
@section('title','ข้อมูลการเติมน้ำมัน')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_red.css">
    <style>
        .innerText{
            transition: 0.4s;
        }
        .innerText:hover{
            color: #c44569;
        }

        .toFuel {
            width: 50px;
            height: 50px;
            background: #e13031;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            -moz-transition: 0.3s;
            -webkit-transition: 0.3s;
            -o-transition: 0.3s;
            transition: 0.3s;
            -moz-box-shadow: 4px 4px 8px 0 rgba(0, 0, 0, 0.4);
            -webkit-box-shadow: 4px 4px 8px 0 rgba(0, 0, 0, 0.4);
            box-shadow: 4px 4px 8px 0 rgba(0, 0, 0, 0.4);
            color: #fff;
            position: fixed;
            right: 35px;
            bottom: 40px;
            display: none;
            overflow: hidden;
            text-align: center;
            text-decoration: none;
            z-index: 99999;
        }

        .toFuel:hover {
            color: #fff;
            background: #3e3e3e;
            text-decoration: none;
        }

        #dateAir{
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #535c68;
            background-color: #fbfbfb;
            background-clip: padding-box;
            border: 1px solid #bababa;
            border-radius: 2px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        #dateAir:hover{
            cursor: pointer;
        }

        .firstTime{
            display: initial;
            font-size: 14px;
            color: #343a40;
            transition: 0.4s;
        }

        .firstTime:hover{
            font-size: 20px;
            color: #4834d4;
        }
    </style>
@endsection
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">ข้อมูลการเติมน้ำมันของ {{$car->name}}</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item active">ข้อมูลของ {{$car->name}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-bottom: 300px">
        <div class="shadow bg-white rounded">
            <div class="card intable cardColor cardStyleMargin" style="padding-bottom: 100px">
                <span>
                    <h3 id="headTopic" style="display: initial">ทั้งหมด</h3>
                    <div class="float-right" style="margin-top: -5px">
                        <a id="goEdit" class="btn btn-sm btn-info text-white waves-effect waves-light" data-toggle="tooltip" title="แก้ไขข้อมูลรถ" data-placement="top"><i class="far fa-edit"></i></a>
                        <a id="delete" class="btn btn-sm btn-danger text-white waves-effect waves-light" data-toggle="tooltip" title="ลบรถคันนี้" data-placement="top"><i class="far fa-trash-alt"></i></a>
                    </div>
                </span>
                <hr style="margin-top: 0px">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            @if ($logs)
                                <?php
                                $color = ['success', 'warning', 'info', 'danger', 'primary'];
                                ?>
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="col-12 col-md-11">
                                            <label for="dateAir">เลือกตามเดือน</label>
                                            <input id="dateAir" class="flatpickr flatpickr-input text-center"
                                                   type="text" name="dateAir" readonly>
                                            <button id="queryMonth" class="btn btn-warning text-white waves-effect waves-light" style="margin-top: -3px"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                        <div class="col-12 col-md-1">
                                            <a class="btn btn-sm btn-primary waves-light waves-effect float-left float-md-right text-white mt-md-0 mt-2">สรุปยอด</a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="timeline timeline-left">
                                @foreach ($logs as $log)
                                    <?php
                                    $random = rand(0, 4);
                                    ?>
                                    <li class="timeline-inverted timeline-item innerText">
                                        <div class="timeline-badge {{$color[$random]}}"><i class="fas fa-gas-pump"></i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h5 class="timeline-title">{{\Carbon\Carbon::parse($log->filling_date)->format('j F Y')}}</h5>
                                                <p>
                                                    <small><i class="fa fa-clock-o"></i> {{\Carbon\Carbon::parse($log->filling_date)->diffForHumans()}}
                                                    </small>
                                                </p>
                                            </div>
                                            <div class="timeline-body">
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <p class=""><i class="mdi mdi-map-marker"></i> ปั้ม: {{$log->gas_station}}</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class=""><i class="mdi mdi-gas-cylinder"></i> เชื้อเพลิง: {{$log->fuel_type}}&nbsp;({{$log->total_liter}} ลิตร)</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class=""><i class="mdi mdi-cash-multiple"></i> ราคารวม: {{number_format((float)$log->total_price, 2, '.', '')}} บาท</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class=""><i class="mdi mdi-cash"></i> ราคาต่อลิตร: {{$log->price_liter}} บาท/ลิตร</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class=""><i class="mdi mdi-gauge"></i> ระยะทางรวม: {{number_format($log->mileage)}} กิโลเมตร</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class=""><i class="mdi mdi-clock"></i> เวลา: {{\Carbon\Carbon::parse($log->filling_time)->format('H:i')}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                </ul>
                                @else
                                <a href="{{route('fuellog.myLog.refuel',['car'=>$car->token])}}"><p class="firstTime">เริ่มการเติมครั้งแรกได้เลย >> <i class="mdi mdi-gas-station"></i></p></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{route('fuellog.myLog.refuel',['car'=>$car->token])}}" id="toFuel" class="toFuel" style="display: block;line-height: 49px;font-size: 22px;font-weight: 900;"><i class="mdi mdi-plus"></i></a>

@stop

@section('script')

    <script src="{{asset('libs/echarts/dist/echarts-en.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <script>
        var color = ['success', 'warning', 'info', 'danger', 'primary'];
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        $(document).ready(function () {
            var car_id = '{!! !empty($logs[0]) == true ? $logs[0]->car_id:null !!}';
            $("#dateAir").flatpickr({
                dateFormat: "M-Y",
                mode: 'single',
                defaultDate: 'today',
                maxDate: "today",
                disableMobile: "true",
                minDate: new Date('{{\Carbon\Carbon::parse($last_year)->format("Y/m/d")}}'),
                onChange: function() {
                    const time = $('#dateAir').val();
                    if (car_id != null){
                        queryMonth(time,car_id);
                    }
                }
            });

            $('#queryMonth').on('click tap',function () {
                const time = $('#dateAir').val();
                if (car_id != null){
                    queryMonth(time,car_id);
                }
            });

        });

        function queryMonth(date,car) {
            $.ajax({
                url: '{!! url('/api/fuel/mylog/query') !!}',
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {date: date,car: car}
            }).done(function (msg) {
                let data = JSON.parse(JSON.parse(JSON.stringify(msg)));
                if (data.status === true) {
                    $('#headTopic').text('In '+data.date_Show);
                    $('.timeline').empty();
                    $.each(data.logs, function (index, val) {
                        let number = Math.floor(Math.random() * 4);
                        let filling_date = new Date(val.filling_date);
                        let filling_time = val.filling_time.split(':');
                        let date_pass = moment(val.filling_date, "YYYY-MM-DD");
                        let date_ago = date_pass.fromNow();
                        $('.timeline').append('<li class="timeline-inverted timeline-item innerText">\n' +
                            '                                            <div class="timeline-badge '+color[number]+'"><i class="fas fa-gas-pump"></i>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="timeline-panel">\n' +
                            '                                                <div class="timeline-heading">\n' +
                            '                                                    <h5 class="timeline-title">'+filling_date.getDate()+" "+monthNames[filling_date.getMonth()]+" "+filling_date.getFullYear()+'</h5>\n' +
                            '                                                    <p>\n' +
                            '                                                        <small><i class="fa fa-clock-o"></i> '+date_ago+'\n' +
                            '                                                        </small>\n' +
                            '                                                    </p>\n' +
                            '                                                </div>\n' +
                            '                                                <div class="timeline-body">\n' +
                            '                                                    <div class="row">\n' +
                            '                                                        <div class="col-12 col-md-4">\n' +
                            '                                                            <p class=""><i class="mdi mdi-map-marker"></i> ปั้ม: '+val.gas_station+'</p>\n' +
                            '                                                        </div>\n' +
                            '                                                        <div class="col-12 col-md-4">\n' +
                            '                                                            <p class=""><i class="mdi mdi-gas-cylinder"></i> เชื้อเพลิง: '+val.fuel_type+'&nbsp;('+val.total_liter+' ลิตร)</p>\n' +
                            '                                                        </div>\n' +
                            '                                                        <div class="col-12 col-md-4">\n' +
                            '                                                            <p class=""><i class="mdi mdi-cash-multiple"></i> ราคารวม: '+numberWithCommasFloat(val.total_price)+' บาท</p>\n' +
                            '                                                        </div>\n' +
                            '                                                        <div class="col-12 col-md-4">\n' +
                            '                                                            <p class=""><i class="mdi mdi-cash"></i> ราคาต่อลิตร: '+val.price_liter+' บาท/ลิตร</p>\n' +
                            '                                                        </div>\n' +
                            '                                                        <div class="col-12 col-md-4">\n' +
                            '                                                            <p class=""><i class="mdi mdi-gauge"></i> ระยะทางรวม: '+Number(val.mileage).toLocaleString('en')+' กิโลเมตร</p>\n' +
                            '                                                        </div>\n' +
                            '                                                        <div class="col-12 col-md-4">\n' +
                            '                                                            <p class=""><i class="mdi mdi-clock"></i> เวลา: '+filling_time[0]+":"+filling_time[1]+'</p>\n' +
                            '                                                        </div>\n' +
                            '                                                    </div>\n' +
                            '                                                </div>\n' +
                            '                                            </div>\n' +
                            '                                        </li>')
                    });
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'ไม่พบข้อมูล!',
                        text: 'สำหรับเดือนที่ต้องการ',
                        timer:2500,
                        showConfirmButton: false,
                    })
                }
            });
        }

        function numberWithCommasFloat(x) {
            var amount=parseFloat(x).toFixed(2);
            return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    </script>

@stop