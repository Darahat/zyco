@extends('app')

@section('title', 'Register - Create Account')

{{-- Load required plugins --}}
<x-plugins.firebase />
<x-plugins.firebase-auth-helpers />
<x-plugins.stepper />
<x-plugins.toastr />

@section('content')
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_KEY') }}&callback=initMap&libraries=places&v=weekly"
    defer></script>

<div class="row">
    <div class="col-md-4">
        <div class="hold-transition login-page loginSideDiv" style="background-color: #F4F9FF">
            <img src="{{asset('images/loginimage.png')}}" alt="login_image" class="loginSideImage">
        </div>
    </div>
    <div class="col-md-8 col-sm-12">
        {{-- <div class="d-flex justify-content-end p-3">
            Not registered?&nbsp; <u><b><a href="{{route('user_registration')}}"> Create an account</a> </b></u>
    </div> --}}
    <div class="hold-transition login-page" style="background-color:white">
        <div class="login-box">
            <div class="row">
                <div class="col-md-12 ">
                    <div id="stepper1" class="bs-stepper">
                        <div class="bs-stepper-header">
                            <div class="step" data-target="#test-l-1">
                                <button type="button" class="btn step-trigger">

                                </button>
                            </div>

                            <div class="step" data-target="#test-l-2">
                                <button type="button" class="btn step-trigger">

                                </button>
                            </div>

                            <div class="step" data-target="#test-l-3">
                                <button type="button" class="btn step-trigger">

                                </button>
                            </div>
                            <div class="step" data-target="#test-l-4">
                                <button type="button" class="btn step-trigger">

                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <div class="card p-3">
                                <div id="test-l-1" class="content">
                                    <div>
                                        <img src="{{asset('icons/zyco.png')}}" style="height:75px">
                                        <h4 class="font-weight-bolder">Create a dispatcher account</h4>
                                        {{-- <div id="error" class="text-red"></div> --}}
                                    </div>
                                    <form class="needs-validation" novalidate>
                                        <!-- hidden -->
                                        <fieldset hidden>
                                            <div class="toggle">
                                                <input type="radio" name="user_type" value="Driver" id="user_type"
                                                    checked="checked" />
                                                {{-- <label for="user_type_driver">Driver</label> --}}
                                                {{-- <input type="radio" name="user_type" value="Rider"
                                                        id="user_type_rider" />
                                                    <label for="user_type_rider">Rider</label> --}}
                                            </div>
                                        </fieldset>
                                        <!-- hidden -->

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">

                                                    <input type="text" name="first_name"
                                                        placeholder="{{trans('auth.header.first_name')}}"
                                                        id="first_name" class="form-control " required>

                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">

                                                    <input type="text" name="last_name"
                                                        placeholder="{{trans('auth.header.last_name')}}" id="last_name"
                                                        class="form-control ">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <input type="text" name="email" placeholder="{{trans('auth.header.email')}}"
                                                id="email" required class="form-control  ">

                                        </div>
                                        <div class="form-group">

                                            <input type="password" name="password"
                                                placeholder="{{trans('auth.header.password')}}" id="password" required
                                                class="form-control ">
                                            @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">

                                            <input type="tel" name="mobile_number"
                                                pattern="/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im"
                                                value="+31" placeholder="{{trans('auth.header.mobile_no')}}"
                                                id="mobile_number" class="form-control " required>
                                            <small id="mobile_number_error" class="text-red"></small>
                                            @if ($errors->has('mobile_number'))
                                            <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="base_city"
                                                placeholder="{{trans('auth.header.base_city')}}" id="base_city" required
                                                class="form-control ">
                                            @if ($errors->has('base_city'))
                                            <span class="text-danger">{{ $errors->first('base_city') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group" hidden>
                                            <input type="text" name="referral_code"
                                                placeholder="{{trans('auth.header.referral_code')}}" id="referral_code"
                                                class="form-control ">
                                            @if ($errors->has('referral_code'))
                                            <span class="text-danger">{{ $errors->first('referral_code') }}</span>
                                            @endif
                                        </div>

                                        <div class="text-red" id="sentError">

                                        </div>
                                        <div id="sign-in-button"></div>

                                        <span class="text-muted" style="font-size:10px;line-height: 1;">
                                            * Required
                                            <br>
                                            By proceeding, I agree to Taxi Plaza's <a href="#">Terms of Use</a> and
                                            acknowledge
                                            that
                                            I have read
                                            the <a href="#">Privacy Policy</a> .
                                            <br>
                                            I also agree that Taxi Plaza's or its representatives may contact me by
                                            email,
                                            phone, or SMS (including by automated means) at the email address or
                                            number I
                                            provide, including for marketing purposes.</span><br><br>
                                        <div class="row">
                                            <div class="col-md-6 justify-content-left">
                                                <a href="{{route('login')}}"><u>Sign in</u> </a>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button class="btn btn-primary float-right g-recaptcha" id="sendOtp"
                                                    data-sitekey="6LdYQQ8hAAAAAH1qvC4ufbT_8nFcRIIJ6M2o8ZBG"
                                                    data-callback='onSubmit' data-action='submit'>Next</button>
                                            </div>
                                    </form>
                                    <!-- <div class="col-md-6 justify-content-left">
                                                    <button type="submit" class="btn primary-color  ">Create
                                                        Account</button>
                                                </div> -->
                                </div>
                            </div>
                            <div id="test-l-2" class="content">
                                <div class="text-center">
                                    <img src="{{asset('icons/zyco.png')}}" style="height:75px">
                                    <h4>Enter your security code</h4>
                                    <small id="sentSuccess" class="text-muted" role="alert">
                                    </small>

                                </div>

                                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                    <input class="m-2 text-center form-control rounded" type="text" id="code_digit_1"
                                        maxlength="1" required />
                                    <input class="m-2 text-center form-control rounded" type="text" id="code_digit_2"
                                        maxlength="1" required />
                                    <input class="m-2 text-center form-control rounded" type="text" id="code_digit_3"
                                        maxlength="1" required />
                                    <input class="m-2 text-center form-control rounded" type="text" id="code_digit_4"
                                        maxlength="1" required />
                                    <input class="m-2 text-center form-control rounded" type="text" id="code_digit_5"
                                        maxlength="1" required />
                                    <input class="m-2 text-center form-control rounded" type="text" id="code_digit_6"
                                        maxlength="1" required />
                                </div>
                                <small class="text-danger" id="errorOtp"></small>
                                <small id="error" class="text-danger" role="alert"></small>

                                <div class="text-right">
                                    <small><a id="resendOtp" href="#">I didn't recive a code</a></small>
                                </div>
                                <br>


                                <div class="row">
                                    <div class="col-md-6">
                                        <button class="btn btn-primary " onclick="stepper1.previous()"><i
                                                class="fas fa-arrow-left"></i></button>

                                    </div>
                                    <div class="col-md-6 ">
                                        <!--  <button class="btn btn-primary float-right"
                                            id="VerificationCodeSubmit">Next</button> -->

                                    </div>
                                </div>
                            </div>
                            </form>
                            <div id="test-l-3" class="content">
                                <div id="continueToDashboard"
                                    class="inputs d-flex flex-row justify-content-center mt-2">
                                    <div>
                                        <h4>Registration Completed</h4>
                                        <br>
                                        <p>Your registration has been completed successfully.
                                            You will be redirected to the Dashboard in a few seconds.</p>
                                        <button class="btn btn-primary" onclick="sendToDashboardNow()">Continue <i
                                                class="fas fa-arrow-right"></i></button>
                                    </div>
                                </div>

                            </div>
                            <div id="test-l-4" class="content">
                                asdfaf
                                <button class="btn btn-primary" onclick="stepper1.next()">Next</button>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <small style="font-size:10px">English (United Kingdom)❤</small>
                            </div>
                            <div class="col-md-2">
                                <small style="font-size:10px" class="form-text text-muted">
                                    Help
                                </small>
                            </div>
                            <div class="col-md-2">
                                <small style="font-size:10px" class="form-text text-muted">
                                    Privacy
                                </small>
                            </div>
                            <div class="col-md-2">
                                <small style="font-size:10px" class="form-text text-muted">
                                    Terms
                                </small>
                            </div>
                        </div><br><br>
                        <div> <small class="form-text text-muted">This site is protected by reCAPTCHA
                                and the Google
                                Privacy
                                Policy and Terms of Service apply.</small></div>
                    </div>

                    <!-- bs stepper -->
                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<!-- <script src="{{ asset('assets/js/authStepper.js') }}"></script> -->
<script>
var stepper1Node = document.querySelector('#stepper1')
var stepper1 = new Stepper(document.querySelector('#stepper1'))

stepper1Node.addEventListener('show.bs-stepper', function(event) {
    console.warn('show.bs-stepper', event)
})
stepper1Node.addEventListener('shown.bs-stepper', function(event) {
    console.warn('shown.bs-stepper', event)
})
</script>





<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

<script>
// Firebase configuration
var firebaseConfig = {
    apiKey: "{{ env('FIREBASE_API_KEY') }}",
    authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
    projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
    storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
    messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
    appId: "{{ env('FIREBASE_APP_ID') }}"
};

// Initialize Firebase
if (!firebase.apps.length) {
    firebase.initializeApp(firebaseConfig);
} else {
    firebase.app(); // if already initialized, use that one
}
</script>

<script type="text/javascript">
var getMobileNumber = '';
var user_type = '';
var first_name = '';
var last_name = '';
var password = '';
var email = '';
var mobile_number = '';

var base_city = '';
var referral_code = '';
var email_success = '';
var mobileNumber_success = '';
window.onload = function() {
    render();
};

function render() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sign-in-button', {
        'size': 'invisible',
        'callback': (response) => {
            // onSubmit(response);
        }
    });
    recaptchaVerifier.render();
}
$("#sendOtp").click(function() {

    user_type = $('#user_type').val();
    first_name = $('#first_name').val();
    last_name = $('#last_name').val();
    password = $('#password').val();
    email = $('#email').val();
    mobile_number = $('#mobile_number').val();
    base_city = $('#base_city').val();
    referral_code = $('#referral_code').val();
    getMobileNumber = mobile_number;
    if (first_name == '') {
        $('#first_name').addClass('is-invalid');
        $('#first_name').after(
            '<div id="email-error" class="text-danger" <strong>This field is required <strong></div>');
    } else if (last_name == '') {
        $('#last_name').addClass('is-invalid');
        $('#last_name').after(
            '<div id="email-error" class="text-danger" <strong>This field is required <strong></div>');
    } else if (password == '') {
        $('#password').addClass('is-invalid');
        $('#password').after(
            '<div id="email-error" class="text-danger" <strong>This field is required <strong></div>');
    } else if (mobile_number == '') {
        $('#mobile_number').addClass('is-invalid');
        $('#mobile_number').after(
            '<div id="email-error" class="text-danger" <strong>This field is required <strong></div>');
    } else if (base_city == '') {
        $('#base_city').addClass('is-invalid');
        $('#base_city').after(
            '<div id="email-error" class="text-danger" <strong>This field is required <strong></div>');
    } else if (email == '') {
        $('#email').addClass('is-invalid');
        $('#email').after(
            '<div id="email-error" class="text-danger" <strong>This field is required <strong></div>');
    } else if (email_success == false) {
        $('#email').addClass('is-invalid');
        // $('#email').after('<div id="email-error" class="text-danger" <strong>T<strong></div>');
    } else if (mobileNumber_success == false) {
        // $('#email').addClass('is-invalid');
        // $('#email').after('<div id="email-error" class="text-danger" <strong>T<strong></div>');

    } else {

        return phoneSendAuthForRegistration(getMobileNumber);
    }


});
$("#VerificationCodeSubmit").click(function() {
    return codeverify();
})
$("#resendOtp").click(function() {


    return phoneSendAuthForRegistration(getMobileNumber);
})

function phoneSendAuthForRegistration(number) {



    firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {


        stepper1.next();
        window.confirmationResult = confirmationResult;
        coderesult = confirmationResult;
        console.log(coderesult);

        let reg = /.{1,10}/
        $("#sentSuccess").text("Enter the code we sent to your mobile " + number.replace(reg, (m) => "X".repeat(
            m.length)));
        $("#sentSuccess").show();

    }).catch(function(error) {

        $("#sentError").text("");
        $("#sentError").show();
    });

}

function codeverify() {
    var codedigit1 = $("#code_digit_1").val();
    var codedigit2 = $("#code_digit_2").val();
    var codedigit3 = $("#code_digit_3").val();
    var codedigit4 = $("#code_digit_4").val();
    var codedigit5 = $("#code_digit_5").val();
    var codedigit6 = $("#code_digit_6").val();
    var verificationCode = codedigit1 + "" + codedigit2 + "" + codedigit3 + "" + codedigit4 + "" + codedigit5 +
        "" +
        codedigit6;
    // alert(verificationCode);
    var code = verificationCode;
    if (codedigit1 == '' || codedigit2 == '' || codedigit3 == '' || codedigit4 == '' || codedigit5 == '' ||
        codedigit6 == '') {
        $("#errorOtp").text("Verification code field is empty. Please insert 6 digit code properly");
        $("#errorOtp").show();
    } else {
        coderesult.confirm(code).then(function(result) {
            var user = result.user;
            console.log(user);
            $(document).ready(function() {
                $.ajax({
                    type: "POST",
                    url: '<?= route("register.custom") ?>',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        user_type: user_type,
                        first_name: first_name,
                        last_name: last_name,
                        password: password,
                        email: email,
                        mobile_number: mobile_number,
                        base_city: base_city,
                        referral_code: referral_code
                    },
                    success: function(data) {
                        if (data) {
                            alert('hola');



                            $.ajax({
                                type: "GET",
                                url: '<?= route("RegistrationComplete") ?>',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    value: email,
                                    table: 'users',
                                    field: 'email',

                                },
                                success: function(data) {
                                    if (data) {
                                        // var user = result.user;
                                        // console.log(user);
                                        stepper1.next();
                                        waitToGoDashboard();
                                    } else {

                                        document.getElementById(
                                                'password_error').innerHTML =
                                            'Email Send Failed' // alert("Error");
                                    }
                                },
                                error: function(err) {}
                            });



                        } else {

                            document.getElementById('login_error').innerHTML =
                                'Please enter a correct email and password.'
                            // alert("Error");
                        }
                    },
                    error: function(err) {

                    }
                });
            });



        }).catch(function(error) {
            $('#code_digit_1').addClass('form-control danger');
            $('#code_digit_2').addClass('form-control danger');
            $('#code_digit_3').addClass('form-control danger');
            $('#code_digit_4').addClass('form-control danger');
            $('#code_digit_5').addClass('form-control danger');
            $('#code_digit_6').addClass('form-control danger');

            $("#errorOtp").text('Your provided verification code is incorrect');

            $("#errorOtp").show();


        });
    }
}

function waitToGoDashboard() {
    setTimeout(sendToDashboardNow, 5000)
}

function sendToDashboardNow() {
    window.location.href = 'https://app.zyco.nl/user-dashboard';
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function(event) {

    function OTPInput() {
        const inputs = document.querySelectorAll('#otp > *[id]');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('keydown', function(event) {
                if (event.key === "Backspace") {
                    inputs[i].value = '';
                    if (i !== 0) inputs[i - 1].focus();
                } else {
                    if (i === inputs.length - 1 && inputs[i].value !== '') {
                        return true;
                    } else if (event.keyCode > 47 && event.keyCode < 58) {
                        inputs[i].value = event.key;
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                    } else if (event.keyCode > 64 && event.keyCode < 91) {
                        inputs[i].value = String.fromCharCode(event.keyCode);
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                    }
                }
            });
        }
    }
    OTPInput();


});



$(document).ready(function() {
    var startTimer;
    $('#email').on('keyup', function() {
        clearTimeout(startTimer);
        let email = $(this).val();
        startTimer = setTimeout(checkEmail, 500, email);
    });

    $('#email').on('keydown', function() {
        clearTimeout(startTimer);
    });

    function checkEmail(email) {
        $('#email-error').remove();
        if (email.length > 1) {
            $.ajax({
                type: 'post',
                url: "{{ route('checkEmail') }}",
                data: {
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    email_success = data.success;
                    $("#email").removeClass("is-invalid");
                    $("#email").removeClass("is-valid");
                    if (data.success == false) {
                        $('#email').addClass('is-invalid');
                        $('#email').after('<div id="email-error" class="text-danger" <strong>' +
                            data.message[0] + '<strong></div>');
                    } else {
                        // alert("hello");

                        $('#email').addClass('is-valid');
                        // $('#email').after('<div id="email-error" class="text-success" <strong>'+data.message+'<strong></div>');
                    }

                }
            });
        } else {
            $('#email').after(
                '<div id="email-error" class="text-danger" <strong>Email address can not be empty.<strong></div>'
            );
        }
    }
});

$(document).ready(function() {

    $('#code_digit_6').keydown(function(event) {
        $("#errorOtp").text('Please wait......');
        return codeverify();

    });

});

$(document).ready(function() {


    $('#mobile_number').change(function() {
        var value = $("#mobile_number").val()
        var mobile_number = value.replaceAll(' ', '')

        let total_length = mobile_number.length;

        if (total_length == '9') {

            $("#mobile_number").val("+31" + mobile_number);
        }
        if (total_length == '10') {

            if (mobile_number.substr(0, 1) == '0') {

                $("#mobile_number").val("+31" + mobile_number.slice(1, 10));
            }
        } else {
            $("#mobile_number").val();
        }
    });
    var startTimer;
    $('#mobile_number').on('keyup', function() {
        clearTimeout(startTimer);
        let mobile_number = $(this).val();
        startTimer = setTimeout(checkMobileNumber, 500, mobile_number);
    });

    $('#mobile_number').on('keydown', function() {
        clearTimeout(startTimer);
    });

    function checkMobileNumber(mobile_number) {
        $('#mobile-error').remove();
        if (mobile_number.length > 1) {
            $.ajax({
                type: 'post',
                url: "{{ route('checkMobileNumber') }}",
                data: {
                    mobile_number: mobile_number,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    mobileNumber_success = data.success;
                    $("#mobile_number").removeClass("is-invalid");
                    $("#mobile_number").removeClass("is-valid");
                    if (data.success == false) {
                        $('#mobile_number').addClass('is-invalid');
                        $('#mobile_number').after(
                            '<div id="mobile-error" class="text-danger" <strong>' + data
                            .message[0] + '<strong></div>');
                    } else {
                        // alert("hello");

                        $('#mobile_number').addClass('is-valid');

                        // $('#mobile_number').addClass('is-valid');
                        $('#mobile_number').after(
                            // '<div id="email-error" class="text-success" <strong>' + data
                            // .message[0] + '<strong></div>'
                        );
                    }
                }
            });
        } else {
            $('#mobile_number').after(
                '<div id="mobile-error" class="text-danger" <strong>Mobile number can not be empty.<strong></div>'
            );
        }
    }
});

// scripts.js custom js file
$(document).ready(function() {
    google.maps.event.addDomListener(window, 'load', initialize);
});

function initialize() {
    var input = document.getElementById('base_city');
    var autocomplete = new google.maps.places.Autocomplete(input);
}
$(document).ready(function() {
    // $('#emailValidation').prop('disabled', true);
    $('#email').on('input', function() {
        var val = $('#email').filter(function() {
            return this.value.trim().length !== 0;
        }).length === 0;

        // $('#emailValidation').prop('disabled', val);
    });

});

function onSubmit(token) {
    // alert(token);
    document.getElementById("demo-form").submit();
}
</script>
@endsection
<!-- <div class="mt-4 mb-3 " >
  <b>{{trans('auth.header.sign_up_using')}}</b>
  </div>
  
  <div class="row">
  <div class="col-2">
  <button type="button" class="btn btn-light"><img src="{{asset('icons/google.png')}}" style="height:1.5rem" alt="">
  </button>
  </div>
  <div class="col-2">
  <button type="button" class="btn btn-dark"><img src="{{asset('icons/windows.png')}}" style="height:1.5rem" alt="">
  </button>
  </div>
  <div class="col-2">
  <button type="button" class="btn" style="background-color: #6001D1"><img src="{{asset('icons/yahoo.png')}}" style="height:1.5rem" alt="">
  </button>
  </div>
  <div class="col-2">
  <button type="button" class="btn btn-light"><img src="{{asset('icons/apple.png')}}" style="height:1.5rem" alt="">
  </button>
  </div>
  <div class="col-2">
  <button type="button" class="btn  " style="background-color: #1976D2" #1976D2><img src="{{asset('icons/facebook.png')}}" style="height:1.5rem" alt="">
  </button>
  </div>
  </div> -->



{{-- $("#test").on("keypress", function (e) {
    if (97 == e.keyCode || 65 == e.keyCode) {
        e.preventDefault();
        var newString = $("#test").val() + "S";
        $("#test").val(newString);
    }
}); --}}