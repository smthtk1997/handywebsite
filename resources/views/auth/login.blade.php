@extends('auth.header')
@section('title','Login')
@section('content')

    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(imgs/auth-bg.jpg) no-repeat center center;">
        <div class="auth-box">
            <div id="loginform">
                <div class="logo">
                    <h3 class="font-medium mb-3">ลงชื่อเข้าใช้</h3>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                </div>
                                <input id="email" type="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="อีเมล">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback text-center mt-3" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="รหัสผ่าน">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback text-center mt-3" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="remember">จดจำฉัน</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-xs-12 p-b-20">
                                    <button class="btn btn-block btn-lg btn-info block-default" type="submit">เข้าสู่ระบบ</button>
                                </div>
                                <hr>
                                <a href="#" class="btn btn-block btn-lg btn-facebook"><i class="fab fa-facebook-square"></i>&nbsp;เข้าสู่ระบบด้วย Facebook</a>
                            </div>
                            <div class="form-group m-b-0 mt-3">
                                <div class="col-sm-12 text-center">
                                    ยังไม่มีบัญชีใช่ไหม ? <a href="{{route('register')}}" class="text-info m-l-5"><b>สมัครสมาชิก</b></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('libs/block-ui/jquery.blockUI.js')}}"></script>
    <script src="{{asset('extra-libs/block-ui/block-ui.js')}}"></script>
@endsection
