@extends('app')

@section('title', 'Forgot Email')

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
                    <h4 class="mt-3">Forgot Your Email?</h4>
                    <p class="text-muted">Enter your mobile number to retrieve your email</p>
                </div>
                <form method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="tel" class="form-control" id="mobile" name="mobile_number" placeholder="+31612345678" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Retrieve Email</button>
                    <div class="text-center mt-3">
                        <a href="{{ route('signin_option') }}">Back to Sign In Options</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
