@extends('layouts.header')
@section('title','จัดการผู้ใช้')
@section('style')
    <style>

    </style>
@stop
@section('content')
    <div class="page-breadcrumb withMargin">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">จัดการผู้ใช้</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.index')}}">หน้าหลักระบบ</a>
                            </li>
                            <li class="breadcrumb-item">ดูแลระบบ</li>
                            <li class="breadcrumb-item active" aria-current="page">จัดการผู้ใช้</li>
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
                    <label class="section-title">จัดการผู้ใช้</label>
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
            @if (!empty($users))
                <div style="overflow-x: auto;display: block;width: 100%">
                    <table class="table table-bordered">
                        <thead class="thead-colored" style="background-color: #dee2e6;color: #343a40;">
                        <tr class="myNowrap">
                            <th class="wd-10p">อีเมล</th>
                            <th class="">ชื่อ</th>
                            <th class="">เบอร์โทร</th>
                            <th>วันที่สมัคร</th>
                            <th class="wd-10p">แก้ไขล่าสุด</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td class="text-info">{{$user->email}}</td>
                                <td class="">{{$user->name}}</td>
                                <td class="">{{$user->telephone ?? '-'}}</td>
                                <td>{{\Carbon\Carbon::parse($user->created_at)->format('d / M / Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($user->updated_at)->format('d / M / Y')}}</td>
                                <td class="text-center align-middle">
                                    @if ($user->status == 0)
                                        <a href="{{route('admin.maintenance.update.user.status',['user'=>$user->token,'status'=>md5('1')])}}" class="btn btn-success waves-light waves-effect btn-rounded btn-sm" onclick='return confirm("ต้องการเปลี่ยนสถานะเป็น \"ระงับ\" ใช่ หรือ ไม่ ?")'>เปิดใช้งาน</a>
                                        @else
                                        <a href="{{route('admin.maintenance.update.user.status',['user'=>$user->token,'status'=>md5('0')])}}" class="btn btn-danger waves-light waves-effect btn-rounded btn-sm" onclick='return confirm("ต้องการเปลี่ยนสถานะเป็น \"เปิดใช้งาน\" ใช่ หรือ ไม่ ?")'>ถูกระงับ</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-danger">ไม่มีผู้ใช้ในระบบ</p>
            @endif
        </div>
    </div>
@stop
@section('script')

@stop