@extends('layouts.header')
@section('title','ข้อมูลผู้ใช้')
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h3 class="slim-pagetitle">ข้อมูลผู้ใช้</h3>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item active">ข้อมูลผู้ใช้</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-bottom: 300px">
        <div class="shadow bg-white rounded">
            <div class="card intable cardColor cardStyleMargin">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="text-center" style="margin-bottom: 40px;">
                                <img alt="user" class="rounded-circle mr-3" src="{{url('user_img/'.Auth::user()->avatar)}}" style="object-fit: cover;width: 200px;height: 200px;border-radius: 50%;margin-top: -3px">
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label for="user_email">อีเมล</label>
                                    <input type="text" id="user_email" class="mt-1 mb-1 form-control" name="user_email"  value="{{$user->email}}" readonly>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="user_name">ชื่อ-สกุล</label>
                                    <input type="text" id="user_name" class="mt-1 mb-1 form-control" name="user_name"  value="{{$user->name}}" readonly>
                                </div>
                                <div class="col-12 col-md-6 mt-md-2">
                                    <label for="user_tel">เบอร์โทรศัพท์</label>
                                    <input type="text" id="user_tel" class="mt-1 mb-1 form-control" name="user_tel"  value="{{$user->telephone}}" readonly>
                                </div>
                                <div class="col-12 col-md-6 mt-md-2">
                                    <label for="user_status">สถานะ</label>
                                    <input type="text" id="user_status" class="mt-1 mb-1 form-control {{$user->status == 0 ? 'text-success':'text-danger'}}" name="user_status"  value="{{$user->status == 0 ? 'Active':'Suspend'}}" readonly>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button data-toggle="modal" data-target="#changePass" class="btn btn-success waves-effect waves-light">เปลี่ยนรหัสผ่าน</button>
                                <button data-toggle="modal" data-target="#editInfo" class="btn btn-info waves-effect waves-light float-right">แก้ไขข้อมูลส่วนตัว</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal changePass -->
                <div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="addBrand">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel1">เปลี่ยนรหัสผ่าน</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form action="{{ route('user.change.password') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group {{ $errors->has('current-password') ? ' has-error' : '' }}">
                                        <label for="current-password" class="col-md-4 control-label">รหัสผ่านเก่า</label>
                                        <input id="current-password" type="password" class="form-control" name="current-password" required>
                                        @if ($errors->has('current-password'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('current-password') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                        <label for="new-password" class="col-md-4 control-label">รหัสผ่านใหม่</label>
                                        <input id="new-password" type="password" class="form-control" name="new-password" required>
                                        @if ($errors->has('new-password'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('new-password') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="new-password-confirm" class="col-md-4 control-label">ยืนยันรหัสผ่าน</label>
                                        <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" >ปิด</button>
                                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal edit -->
                <div class="modal fade" id="editInfo" tabindex="-1" role="dialog" aria-labelledby="addBrand">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel1">แก้ไขข้อมูลส่วนตัว</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form action="{{ route('user.edit.user.information') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <img id="preview_img" class="centerOfRow rounded-circle" src="{{url('user_img/'.Auth::user()->avatar)}}" style="object-fit: cover;width: 100px;height: 100px;border-radius: 50%">
                                    <div class="form-group">
                                        <label for="user_img">เปลี่ยนรูปโปรไฟล์</label>
                                        <div class="custom-file">
                                            <input type="file" accept="image/*" class="custom-file-input" name="user_img" id="user_img" data-toggle="tooltip" data-placement="bottom" title="รูปโปรไฟล์" onchange="$(this).next().after().text($(this).val().split('\\').slice(-1)[0])">
                                            <label class="custom-file-label" for="user_img" style="font-weight: normal">เลือกไฟล์</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="addBrand">อีเมล</label>
                                        <input type="email" id="email_edit" class="mt-1 mb-1 form-control" name="email_edit" value="{{$user->email}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="addBrand">ชื่อ-สกุล</label>
                                        <input type="text" id="name_edit" class="mt-1 mb-1 form-control" name="name_edit" value="{{$user->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="addBrand">เบอร์โทร</label>
                                        <input type="text" id="telephone_edit" class="mt-1 mb-1 form-control" name="telephone_edit" value="{{$user->telephone}}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" >ปิด</button>
                                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('script')
    <script>
        $(document).ready(function () {
            $("#user_img").change(function() {
                readURL(this);
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview_img').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@stop