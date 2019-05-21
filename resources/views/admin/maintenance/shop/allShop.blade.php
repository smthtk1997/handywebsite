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
    <div class="container-fluid" style="min-height: 100vh;padding-top: 0px;margin-bottom: 200px">
        <div class="section-wrapper">
            <div class="row mb-3">
                <div class="col-12 col-md-10">
                    <label class="section-title">สถานที่ทั้งหมด</label>
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
{{--        <!-- Modal Add -->--}}
{{--        <div class="modal fade" id="addBrand" tabindex="-1" role="dialog" aria-labelledby="addBrand">--}}
{{--            <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h4 class="modal-title" id="exampleModalLabel1">เพิ่มยี่ห้อในระบบ</h4>--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
{{--                    </div>--}}
{{--                    <form action="{{ route('admin.fuellog.brand.store') }}" method="post" enctype="multipart/form-data">--}}
{{--                        @csrf--}}
{{--                        <div class="modal-body">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="addBrand">ยี่ห้อ <span class="text-danger">*</span></label>--}}
{{--                                <input type="text" id="addBrand" class="mt-1 mb-1 form-control" name="addBrand" value="" placeholder="ยี่ห้อ">--}}
{{--                            </div>--}}
{{--                            <div style="margin-top: 0.25rem;">--}}
{{--                                <label for="img_logo">รูปภาพยี่ห้อ <span class="text-danger">*</span></label>--}}
{{--                                <div class="custom-file">--}}
{{--                                    <input type="file" accept="image/*" class="custom-file-input" name="img_logo" id="img_logo" required data-toggle="tooltip" data-placement="bottom" title="รูปภาพยี่ห้อ" onchange="$(this).next().after().text($(this).val().split('\\').slice(-1)[0])">--}}
{{--                                    <label class="custom-file-label" for="car_img" style="font-weight: normal">เลือกไฟล์</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="modal-footer">--}}
{{--                            <button type="button" class="btn btn-default" data-dismiss="modal" >ปิด</button>--}}
{{--                            <button type="submit" class="btn btn-primary">ยืนยัน</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@stop
@section('script')

@stop