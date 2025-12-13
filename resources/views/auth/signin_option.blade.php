@extends('app')

@section('title', 'Sign In Options')

@section('content')
<div class="row bg-white">
    <div class="col-md-7">
        <div class="hold-transition login-page loginSideDiv">
            <img src="{{asset('images/Group 455.png')}}" alt="login_image" class="loginSideImage">
        </div>
    </div>
    <div class="col-md-5 col-sm-12">
        <div class="hold-transition login-page">
            <div class="login-box">
                <div class="text-center">
                    <img src="{{asset('icons/zyco.png')}}" style="height:75px">
                    <h4 class="mt-3">Having Trouble Signing In?</h4>
                    <p class="text-muted">Choose an option to recover your account</p>
                </div>
                <div class="list-group">
                    <a href="{{ route('forget_password') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-key"></i> Forgot Password
                    </a>
                    <a href="{{ route('forget_email') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-envelope"></i> Forgot Email
                    </a>
                    <a href="{{ route('login') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-arrow-left"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
