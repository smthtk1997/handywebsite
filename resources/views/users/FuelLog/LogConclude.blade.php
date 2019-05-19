@extends('layouts.header')
@section('title','ข้อมูลการเติมน้ำมันรายปี')
@section('style')
    <style>

    </style>
@endsection
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">ข้อมูลการเติมน้ำมันรายปีของ {{$car->name}}</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item active">ข้อมูลรายปีของ {{$car->name}}</li>
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
                    <h3 id="headTopic" style="display: initial"></h3>
                </span>
                <hr style="margin-top: 8px">
                <div class="card-body analytics-info">
                    <div class="card-title">
                        <div class="col-3">
                            <label for="year_select">เลือกดูตามปี</label>
                            <select id="year_select" class="form-control" name="year_select" required>
                                <option value="" selected disabled>เลือกดูตามปี</option>
                                @foreach($all_year as $year)
                                    @if ($this_year == $year->all_year)
                                        <option value="{{$year->all_year}}" selected>ปี {{$year->all_year}}</option>
                                    @else
                                        <option value="{{$year->all_year}}" >ปี {{$year->all_year}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="basic-bar" style="height:400px;"></div>
                    <div class="text-center" style="margin-top: 2.5rem">
                        <span id="total_price" class="badge badge-pill badge-dark font-14"></span>
                        <span id="total_liter" class="badge badge-pill badge-info font-14 ml-2"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')

    <script src="{{asset('libs/echarts/dist/echarts-en.min.js')}}"></script>

    <script>

        var logs ;
        var year ;
        var total_price ;
        var price_month ;
        var max_price ;
        var min_price ;
        var total_liter ;
        var liter_month ;
        var max_liter ;
        var min_liter ;

        $(document).ready(function () {
            var car_id = '{!! !empty($car) == true ? $car->id:null !!}';
            var isNull = '{!! $logs_data !!}';

            if (isNull[0] !== undefined){
                logs = JSON.parse(JSON.parse(JSON.stringify({!! json_encode($logs_data) !!})));
                year = '{!! $this_year !!}';
                total_price = logs.total_price;
                price_month = [];
                max_price = 0;
                min_price = 0;

                total_liter = logs.total_liter;
                liter_month = [];
                max_liter = 0;
                min_liter = 0;

                $('#headTopic').text('สรุปข้อมูลของปี '+year);
                $('#total_price').text('ราคารวมทั้งหมด: '+Number(total_price).toLocaleString('en'));
                $('#total_liter').text('จำนวนลิตรทั้งหมด: '+numberWithCommasFloat(total_liter));


                $.each(logs.month_price, function (index, val) {
                    price_month.push(val);
                    if (parseFloat(val) > parseFloat(max_price)){
                        max_price = val
                    }
                    if (parseFloat(val < parseFloat(min_price))){
                        min_price = val;
                    }
                });

                $.each(logs.month_liter, function (index, val) {
                    liter_month.push(val);
                    if (parseFloat(val) > parseFloat(max_liter)){
                        max_liter = val
                    }
                    if (parseFloat(val < parseFloat(min_liter))){
                        min_liter = val;
                    }
                });
                setGraph();

            }else{
                Swal.fire({
                    type: 'warning',
                    title: 'ไม่มีข้อมูลในปีนี้',
                    text: 'กรุณาเลือกช่วงปีอื่นๆ',
                    showConfirmButton: true,
                })
            }

            $('#year_select').on('change',function () {
                const year = $('#year_select option:selected').val();
                if (car_id != null && year !== ''){
                    $.blockUI({ message: null});
                    queryYear(year,car_id);
                }
            });

        });

        function setGraph() {
            var myChart = echarts.init(document.getElementById('basic-bar'));

            var option = {
                // Setup grid
                grid: {
                    left: '3%',
                    right: '3%',
                    bottom: '3%',
                    containLabel: true
                },

                // Add Tooltip
                tooltip : {
                    trigger: 'axis'
                },

                legend: {
                    data:['ราคา','จำนวนลิตร']
                },
                toolbox: {
                    show : true,
                    feature : {
                        magicType : {show: true, type: ['line', 'bar']},
                        // restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                color: ["#364ce5","#f6b93b"],
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data : ['Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sept','Oct','Nov','Dec']
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:['ราคา'],
                        type:'bar',
                        data:[price_month[0], price_month[1], price_month[2], price_month[3], price_month[4], price_month[5], price_month[6], price_month[7], price_month[8], price_month[9], price_month[10], price_month[11]],
                        markPoint : {
                            data : [
                                {name : 'สูงที่สุด', value : max_price, xAxis: price_month.indexOf(max_price), yAxis: max_price+1, symbolSize:30},
                                {name : 'ต่ำที่สุด', value : min_price, xAxis: price_month.indexOf(min_price), yAxis: min_price+1, symbolSize:30}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name : 'Average'}
                            ]
                        }
                    },
                    {
                        name:['จำนวนลิตร'],
                        type:'bar',
                        data:[liter_month[0], liter_month[1], liter_month[2], liter_month[3], liter_month[4], liter_month[5], liter_month[6], liter_month[7], liter_month[8], liter_month[9], liter_month[10], liter_month[11]],
                        markPoint : {
                            data : [
                                {name : 'ลิตรสูงสุด', value : max_liter, xAxis: liter_month.indexOf(max_liter), yAxis: max_liter+1, symbolSize:30},
                                {name : 'ลิตรต่ำสุด', value : min_liter, xAxis: liter_month.indexOf(min_liter), yAxis: min_liter+1, symbolSize:30}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name : 'Average'}
                            ]
                        }
                    }
                ]
            };
            myChart.setOption(option);

            $(window).on('resize', resize);
            // Resize function
            function resize() {
                setTimeout(function() {
                    myChart.resize();
                }, 200);
            }
        }

        function queryYear(year,car) {
            $.ajax({
                url: '{!! url('/api/fuel/mylog/query/year.api') !!}',
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {year: year,car_id: car}
            }).done(function (msg) {
                let data = JSON.parse(JSON.parse(JSON.stringify(msg)));
                console.log(data);
                if (data.status === true) {

                    total_price = data.total_price;
                    price_month = [];
                    max_price = 0;
                    min_price = 0;

                    total_liter = data.total_liter;
                    liter_month = [];
                    max_liter = 0;
                    min_liter = 0;

                    $('#headTopic').text('สรุปข้อมูลของปี '+data.year);
                    $('#total_price').text('ราคารวมทั้งหมด: '+Number(total_price).toLocaleString('en'));
                    $('#total_liter').text('จำนวนลิตรทั้งหมด: '+numberWithCommasFloat(total_liter));


                    $.each(data.month_price, function (index, val) {
                        price_month.push(val);
                        if (parseFloat(val) > parseFloat(max_price)){
                            max_price = val
                        }
                        if (parseFloat(val < parseFloat(min_price))){
                            min_price = val;
                        }
                    });

                    $.each(data.month_liter, function (index, val) {
                        liter_month.push(val);
                        if (parseFloat(val) > parseFloat(max_liter)){
                            max_liter = val
                        }
                        if (parseFloat(val < parseFloat(min_liter))){
                            min_liter = val;
                        }
                    });
                    setGraph();
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'ไม่พบข้อมูล!',
                        text: 'สำหรับปีที่ต้องการ',
                        timer:2500,
                        showConfirmButton: false,
                    })
                }
                $.unblockUI();
            });
        }

        function numberWithCommasFloat(x) {
            var amount=parseFloat(x).toFixed(2);
            return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    </script>

@stop