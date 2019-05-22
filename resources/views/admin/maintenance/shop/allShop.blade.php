@extends('layouts.header')
@section('title','สถานที่ทั้งหมด')
@section('style')
    <style>

    </style>
@stop
@section('content')
    <div class="page-breadcrumb withMargin">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">สถานที่ทั้งหมด</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.index')}}">หน้าหลักระบบ</a>
                            </li>
                            <li class="breadcrumb-item">ดูแลระบบ</li>
                            <li class="breadcrumb-item active" aria-current="page">สถานที่ทั้งหมด</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="margin-top: 30px;min-height: 100vh;padding-top: 0px;margin-bottom: 200px">
        <div class="section-wrapper">
            <div class="row mb-3">
                <div class="col-12 col-md-10">
                    <label class="section-title">สถานที่ทั้งหมด</label>
                </div>
                <div class="col-12 col-md-2">
                    <button type="button" class="btn btn-outline-danger btn-block mt-2" data-toggle="modal" data-target="#actionShop">เพิ่ม/อัพเดท</button>
                </div>
            </div>
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
            @if (!empty($shops))
                <div style="overflow-x: auto;display: block;width: 100%">
                    <table class="table table-bordered">
                        <thead class="thead-colored" style="background-color: #dee2e6;color: #343a40;">
                        <tr class="myNowrap">
                            <th class="">ชื่อ</th>
                            <th class="text-left">ที่อยู่</th>
                            <th>ละติจูด</th>
                            <th>ลองติจูด</th>
                            <th class="text-center">วันที่เพิ่ม</th>
                            <th class="text-center">แก้ไขล่าสุด</th>
                            <th class="text-center">ลบ</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($shops as $shop)
                            <tr>
                                <td class="text-info"><a href="{{route('shop.search.detail',['place_id'=>$shop->place_id])}}" target="_blank">{{$shop->name}}</a></td>
                                <td class="">{{$shop->formatted_address}}</td>
                                <td class="">{{$shop->lat}}</td>
                                <td class="">{{$shop->lng}}</td>
                                <td class="nowrap">{{\Carbon\Carbon::parse($shop->created_at)->format('d / M / Y')}}</td>
                                <td class="nowrap">{{\Carbon\Carbon::parse($shop->updated_at)->format('d / M / Y')}}</td>
                                <td class="text-center align-middle">
                                    <a href="{{route('admin.maintenance.delete.shop',['shop'=>$shop->token])}}" class="text-inverse"><i class="ti-trash text-danger" onclick="return confirm('ต้องการลบใช่ หรือ ไม่ ?')"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="align-content-sm-center align-content-center pt-2">
                        {{$shops->links()}}
                    </div>
                </div>
            @else
                <p class="text-danger">ไม่มีสถานที่ในระบบ</p>
            @endif
        </div>
        <!-- Modal Add -->
        <div class="modal fade" id="actionShop" tabindex="-1" role="dialog" aria-labelledby="addBrand">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">เพิ่ม/อัพเดทสถานที่</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('admin.maintenance.action.shop') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="searchType">ประเภท <span class="text-danger">*</span></label>
                                <select id="searchType" class="form-control" name="searchType" required>
                                    <option value="car" selected>รถยนต์</option>
                                    <option value="6">อู่ซ่อมรถยนต์</option>
                                    <option value="1">ศูนย์รถยนต์</option>
                                    <option value="8">ล้างรถ-เคลือบสี</option>
                                    <option value="5">ปั้มน้ำมัน</option>
                                    <option value="15">ยาง และ ล้อแม็ก</option>
                                    <option value="16">เครื่องเสียง</option>
                                    <option value="17">ประดับยนต์</option>
                                    <option value="9">บริการเช่ารถ</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="searchRange">ระยะค้นหา <span class="text-danger">*</span></label>
                                <select id="searchRange" class="form-control" name="searchRange" required>
                                    <option value="3000">3 กิโลเมตร</option>
                                    <option value="5000" selected>5 กิโลเมตร</option>
                                    <option value="10000">10 กิโลเมตร</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lat">ละติจูด <span class="text-danger">*</span></label>
                                <input type="number" step="any" id="lat" class="mt-1 mb-1 form-control" name="lat" placeholder="lat" required>
                            </div>
                            <div class="form-group">
                                <label for="lng">ลองติจูด <span class="text-danger">*</span></label>
                                <input type="number" step="any" id="lng" class="mt-1 mb-1 form-control" name="lng" placeholder="lng" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <h5 id="waitText" class="text-left text-danger" style="display: none;margin-top: 5px">กรุณารอสักครู่...</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-default" onclick="this.form.submit();$('#waitText').fadeIn(400);this.disabled=true;$(this).text('กำลังทำงาน')">ยืนยัน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')

@stop