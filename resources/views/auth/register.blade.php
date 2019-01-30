@extends('auth.header')
@section('title','Register')
@section('content')

    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(imgs/auth-bg.jpg) no-repeat center center;">
        <div class="auth-box">
            <div id="loginform">
                <div class="logo">
                    <h5 class="font-medium mb-3">Sign Up</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row ">
                                <div class="col-12 ">
                                    <input id="username" type="text" class="form-control form-control-lg{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus placeholder="Username">
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback text-center mt-3" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row ">
                                <div class="col-12 ">
                                    <input id="name" type="text" class="form-control form-control-lg{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback text-center mt-3" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input id="email" type="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback text-center mt-3" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input id="password" type="password" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback text-center mt-3" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" required>
                                        <label class="custom-control-label" for="customCheck1">I agree to all <a href="javascript:void(0)">Terms</a></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center ">
                                <div class="col-xs-12 p-b-20 ">
                                    <button class="btn btn-block btn-lg btn-info " type="submit ">SIGN UP</button>
                                </div>
                            </div>
                            <div class="form-group m-b-0 m-t-10 ">
                                <div class="col-sm-12 text-center ">
                                    Already have an account? <a href="{{route('login')}}" class="text-info m-l-5 "><b>Sign In</b></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection