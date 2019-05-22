@extends('layouts.header')
@section('title','ประกันภัยทั้งหมด')
@section('style')
    <style>

    </style>
@stop
@section('content')
    <div class="page-breadcrumb withMargin">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">ประกันภัยทั้งหมด</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.index')}}">หน้าหลักระบบ</a>
                            </li>
                            <li class="breadcrumb-item">ดูแลระบบ</li>
                            <li class="breadcrumb-item active" aria-current="page">ประกันภัยทั้งหมด</li>
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
                    <label class="section-title">ประกันภัยทั้งหมด</label>
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
            @if (!empty($insurances))
                <div style="overflow-x: auto;display: block;width: 100%">
                    <table class="table table-bordered">
                        <thead class="thead-colored" style="background-color: #dee2e6;color: #343a40;">
                        <tr class="myNowrap">
                            <th class="wd-10p">ชื่อ</th>
                            <th>วันที่เพิ่ม</th>
                            <th class="wd-10p">แก้ไขล่าสุด</th>
                            <th class="text-center">ลบ</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($insurances as $insurance)
                            <tr>
                                <td class="text-info">{{$insurance->name}}</td>
                                <td>{{\Carbon\Carbon::parse($insurance->created_at)->format('d / M / Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($insurance->updated_at)->format('d / M / Y')}}</td>
                                <td class="text-center align-middle">
                                    <a href="{{route('admin.maintenance.delete.insurance',['insurance'=>$insurance->token])}}" class="text-inverse"><i class="ti-trash text-danger" onclick="return confirm('ต้องการลบใช่ หรือ ไม่ ?')"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-danger">ไม่มีประกันในระบบ</p>
            @endif
        </div>
    </div>
@stop
@section('script')

@stop