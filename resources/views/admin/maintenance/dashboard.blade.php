@extends('layouts.header')
@section('title','ภาพรวมระบบ')
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">ภาพรวมระบบ</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item active">ภาพรวมระบบ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-bottom: 300px">
        <div class="shadow bg-white rounded">
            <div class="cardColor cardStyleMargin">
                @if ($shops and $users and $insurances and $brands and $lasted_add)
                    <div  class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex no-block align-items-center">
                                            <div >
                                                <i class="mdi mdi-emoticon font-24"></i>
                                                <p class="font-16 m-b-5">ผู้ใช้ทั้งหมด</p>
                                            </div>
                                            <div class="ml-auto">
                                                <h1  class="font-light text-right">{{$users->count()}}</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="col-12">
                                        <div  class="progress">
                                            <div  aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress-bar bg-info"
                                                  role="progressbar" style="width:100%; height: 6px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div  class="card-body">
                                <div class="row"><div _ngcontent-c2="" class="col-md-12">
                                        <div  class="d-flex no-block align-items-center">
                                            <div>
                                                <i class="mdi mdi-store font-24"></i>
                                                <p class="font-16 m-b-5">สถานที่ทั้งหมด</p>
                                            </div>
                                            <div class="ml-auto">
                                                <h1 class="font-light text-right">{{number_format($shops->count())}}</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="col-12">
                                        <div  class="progress">
                                            <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress-bar bg-success"
                                                 role="progressbar" style="width: 100%; height: 6px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div  class="card">
                            <div  class="card-body">
                                <div  class="row">
                                    <div  class="col-md-12">
                                        <div  class="d-flex no-block align-items-center">
                                            <div>
                                                <i  class="mdi mdi-wrench font-24"></i>
                                                <p  class="font-16 m-b-5">ประกันภัยทั้งหมด</p>
                                            </div>

                                            <div  class="ml-auto">
                                                <h1  class="font-light text-right">{{$insurances->count()}}</h1>
                                            </div>
                                        </div>
                                        <div  class="col-12">
                                            <div  class="progress">
                                                <div  aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress-bar bg-purple" role="progressbar" style="width: 100%; height: 6px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div  class="card">
                            <div  class="card-body">
                                <div  class="row">
                                    <div  class="col-md-12">
                                        <div  class="d-flex no-block align-items-center">
                                            <div>
                                                <i  class="mdi mdi-car font-24"></i>
                                                <p  class="font-16 m-b-5">ยี่ห้อรถทั้งหมด</p>
                                            </div>

                                            <div  class="ml-auto">
                                                <h1  class="font-light text-right">{{$brands->count()}}</h1>
                                            </div>
                                        </div>
                                        <div  class="col-12">
                                            <div  class="progress">
                                                <div  aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress-bar bg-orange" role="progressbar" style="width: 100%; height: 6px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @else
                    <p class="text-danger">เกิดข้อผิดพลาดในการเรียกข้อมูล</p>
                @endif
            </div>
        </div>
        <div class="shadow bg-white rounded">
            <div class="cardColor cardStyleMargin">
        @if ($shops and $users and $insurances and $brands and $lasted_add)
            <div class="card">
                <div class="card-body">
                    <div style="margin-bottom: 1.3rem;margin-top: 1rem">
                        <h4 class="card-title">สถานที่เพิ่มใหม่ล่าสุด</h4>
                    </div>
                    <div style="overflow-x: auto;display: block;width: 100%">
                        <table class="table table-bordered">
                            <thead class="thead-colored" style="background-color: #dee2e6;color: #343a40;">
                            <tr class="myNowrap">
                                <th class="">ชื่อ</th>
                                <th class="text-left">ที่อยู่</th>
                                <th>ละติจูด</th>
                                <th>ลองติจูด</th>
                                <th class="text-center">วันที่เพิ่ม</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($lasted_add as $shop)
                                <tr>
                                    <td class="text-info"><a href="{{route('shop.search.detail',['place_id'=>$shop->place_id])}}" target="_blank">{{$shop->name}}</a></td>
                                    <td class="">{{$shop->formatted_address}}</td>
                                    <td class="">{{$shop->lat}}</td>
                                    <td class="">{{$shop->lng}}</td>
                                    <td class="nowrap">{{\Carbon\Carbon::parse($shop->created_at)->format('d / M / Y')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
            </div>
        </div>
    </div>


@stop

@section('script')

@stop