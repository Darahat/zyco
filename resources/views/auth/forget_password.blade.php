@extends('app')

@section('title', 'Forgot Password')

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
                    <h4 class="mt-3">Forgot Password?</h4>
                    <p class="text-muted">Enter your email to reset your password</p>
                </div>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection