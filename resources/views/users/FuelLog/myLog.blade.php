@extends('layouts.header')
@section('title','ข้อมูลการเติมน้ำมัน')
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">ข้อมูลการเติมน้ำมัน</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item active">ข้อมูลของ บลาๆๆๆ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-bottom: 300px">
        <div class="shadow bg-white rounded">
            <div class="card intable cardColor cardStyleMargin" style="padding-bottom: 100px">
                <a href="{{route('fuellog.myLog.refuel',['car'=>$car->token])}}" class="btn btn-outline-info waves-light waves-effect"><i class="fas fa-plus-circle"></i></a>
            </div>
        </div>
    </div>


@stop

@section('script')

@stop