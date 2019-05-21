@extends('auth.header')
@section('title','สมัครสมาชิก')
@section('content')

    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(imgs/auth-bg.jpg) no-repeat center center;">
        <div class="auth-box">
            <div id="loginform">
                <div class="logo">
                    <h3 class="font-medium mb-3">สมัครสมาชิก</h3>
                </div>
                <hr>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="" id="display_img1" style="margin: auto;">
                                <div class="i-am-centered" style="margin-bottom: 15px;">
                                    <img id="preview_img" class="centerOfRow rounded-circle" src="{{asset('images/users.png')}}" style="object-fit: cover;width: 100px;height: 100px;border-radius: 50%">
                                    <div>
                                        <input type="file" accept="image/*" id="imgupload" value="" name="imgupload" style="display:none" required/>
                                        <a class="centerOfRow text-center" id="OpenImgUpload" style="margin-top: 8px;text-decoration: underline;cursor: pointer;font-size: 12px">อัพโหลดรูปภาพ</a>
                                        <small id="alertIMG" class="text-danger centerOfRow text-center" style="display: none">*กรุณาเลือกรูปภาพ</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input id="email" type="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="อีเมล">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback text-center mt-3" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input id="password" type="password" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="รหัสผ่าน">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback text-center mt-3" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required placeholder="ยืนยันรหัสผ่าน">
                                </div>
                                <small id="notmatch" class="text-muted mt-1 ml-2" style="display: none">
                                    <span style="color: red">Password not match.</span>
                                </small>
                            </div>
                            <div class="form-group row ">
                                <div class="col-12 ">
                                    <input id="name" type="text" class="form-control form-control-lg{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="ชื่อ-นามสกุล">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback text-center mt-3" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row ">
                                <div class="col-12 ">
                                    <input id="tel" type="tel" class="form-control form-control-lg{{ $errors->has('tel') ? ' is-invalid' : '' }}" name="tel" value="{{ old('tel') }}" required autofocus placeholder="เบอร์โทร">
                                    @if ($errors->has('tel'))
                                        <span class="invalid-feedback text-center mt-3" role="alert">
                                            <strong>{{ $errors->first('tel') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-md-12 ">--}}
{{--                                    <div class="custom-control custom-checkbox">--}}
{{--                                        <input type="checkbox" class="custom-control-input" id="customCheck1" required>--}}
{{--                                        <label class="custom-control-label" for="customCheck1">I agree to all <a href="javascript:void(0)">Terms</a></label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group text-center ">
                                <div class="col-xs-12 p-b-20 ">
                                    <button id="btnSubmit" class="btn btn-block btn-lg btn-info " type="submit">สมัครสมาชิก</button>
                                </div>
                            </div>
                            <div class="form-group m-b-0 m-t-10 ">
                                <div class="col-sm-12 text-center ">
                                    มีบัญชีอยู่แล้ว ? <a href="{{route('login')}}" class="text-info m-l-5 "><b>ลงชื่อเข้าใช้</b></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#password').on('keydown keyup',function () {
                if ($('#password').val() != $('#password-confirm').val()){
                    $('#password').css('border-color', 'red');
                    $('#password-confirm').css('border-color', 'red');
                    $('#notmatch').slideDown('slow');
                }else{
                    $('#password').css('border-color', 'green');
                    $('#password-confirm').css('border-color', 'green');
                    $('#notmatch').slideUp('slow');
                }
            });
            $('#password-confirm').on('keydown keyup',function () {
                if ($('#password-confirm').val() != $('#password').val()){
                    $('#password').css('border-color', 'red');
                    $('#password-confirm').css('border-color', 'red');
                    $('#notmatch').slideDown('slow');
                }else{
                    $('#password').css('border-color', 'green');
                    $('#password-confirm').css('border-color', 'green');
                    $('#notmatch').slideUp('slow');
                }
            });

            $('#OpenImgUpload').click(function(){
                $('#imgupload').trigger('click');
            });

            $("#imgupload").change(function() {
                readURL(this);
            });

            $('#btnSubmit').click(function () {
                if ($('#imgupload').val() == ""){
                    $('#alertIMG').fadeIn('slow');
                    alert('กรุณาเลือกรูปภาพ');
                }
            })
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
@endsection