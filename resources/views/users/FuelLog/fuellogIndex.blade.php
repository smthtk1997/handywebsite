@extends('layouts.header')
@section('title','แอพพลิเคชั่นการเติมน้ำมัน')
@section('style')
    <style>
        .superRed{
            background-color: #e13031;
        }

        .card{
            transition: 350ms;
        }

        .card:hover{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.38), 0 6px 20px 0 rgba(0, 0, 0, 0.23);
        }
        /*@media only screen and (max-width: 800px) {*/
        /*    #imgCar{*/
        /*        height: 210px!important*/
        /*    }*/
        /*}*/
    </style>
@stop
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">myFuelLog</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item active">myFuelLog</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="margin-bottom: 300px">
        <div class="shadow bg-white rounded" style="padding: 35px">
            <h3>รถของคุณทั้งหมด</h3>
            <hr style="margin-bottom: 20px">
            <div class="row">
                @if (!empty($cars))
                    @foreach($cars as $car)
                        <!-- col -->
                            <div class="col-12 col-lg-4 col-md-6 d-flex align-items-stretch">
                                <div class="card {{$loop->iteration%2 == 0 ? 'bg-dark':'superRed'}} centerOfRow" style="width: 21rem;height: 16rem">
                                    <div class="card-body" style="padding: 0px;">
                                        <a href="{{route('fuellog.myLog',['car'=>$car->token])}}" class="waves-light waves-effect">
                                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                <!-- Carousel items -->
                                                <div class="carousel-inner">
                                                    <div class="carousel-item flex-column active">
                                                        <img class="centerOfRow" src="{{url('/files/user_car_img/'.$car->img_path)}}" style="object-fit: cover;width: 100%;height: 217px;padding: 0px" id="imgCar">
                                                        <div class="text-white m-t-10" style="padding: 0.4rem;">
                                                            <span><i class="ti-car font-20 text-white"></i>&nbsp;<i>-- {{$car->name}}</i></span>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item flex-column" style="padding: 1.25rem;width: 100%">
                                                        <div style="margin-top: 15px;margin-left: 10px">
                                                            <i class="ti-dashboard font-20 text-white"></i>
                                                            <h3 class="text-white font-medium">{{ucfirst($car->brand)}}</h3>
                                                            <h4 class="text-white font-medium">-- รุ่น {{ucfirst($car->model)}}</h4>
                                                            <h4 class="text-white font-medium">-- เลขทะเบียน {{$car->license}}</h4>
                                                            <div class="text-white m-t-10">
                                                                <i>-- ระยะทางรวม {{number_format($car->mileage)}} กิโลเมตร</i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                @endif
                <div class="col-12 col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="card centerOfRow" style="width: 21rem;height: 16rem;">
                        <div class="card-body" style="padding: 0px;">
                            <div style="position: relative;text-align: center">
                                <a href="{{route('fuellog.app.create.car')}}" style="color: #727f8c;">
                                <img src="{{asset('images/bg_tranparant.png')}}" style="object-fit: cover;width: 100%;height: 217px;padding: 0px;">
                                <div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                    <i class="fas fa-plus-circle" style="font-size: 50px;margin-top: 15px"></i>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('script')

@stop