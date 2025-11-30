
<?php $__env->startSection('content'); ?>
<div class="row bg-white">
    <div class="col-md-7">
        <div class="hold-transition login-page  loginSideDiv">
            <img src="<?php echo e(asset('images/Group 455.png')); ?>" alt="login_image" class="loginSideImage">
        </div>
    </div>
    <div class="col-md-5 col-sm-12">
        <div class="hold-transition login-page">
            <div class="login-box">
                <div class="row">
                    <div class="col-md-12 ">
                        <div id="stepper1" class="bs-stepper">
                            <div class="bs-stepper-header">
                                <div class="step" data-target="#test-l-1">
                                    <button type="button" class="btn step-trigger">
                                        <!-- <span class="bs-stepper-circle">1</span>
                  <span class="bs-stepper-label">First step</span> -->
                                    </button>
                                </div>
                                <!-- <div class="line"></div> -->
                                <div class="step" data-target="#test-l-2">
                                    <button type="button" class="btn step-trigger">
                                        <!-- <span class="bs-stepper-circle">2</span> -->
                                        <!-- <span class="bs-stepper-label">Second step</span> -->
                                    </button>
                                </div>
                                <!-- <div class="line"></div> -->
                                <?php if($result->need_otp == "Enabled"): ?>
                                <div class="step" data-target="#test-l-3">
                                    <button type="button" class="btn step-trigger">
                                        <!-- <span class="bs-stepper-circle">3</span> -->
                                        <!-- <span class="bs-stepper-label">Third step</span> -->
                                    </button>
                                </div>
                                <?php endif; ?>
                                <div class="step" data-target="#test-l-4">
                                    <button type="button" class="btn step-trigger">
                                        <!-- <span class="bs-stepper-circle">3</span> -->
                                        <!-- <span class="bs-stepper-label">Third step</span> -->
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content">
                                <div class=" p-4">
                                    <div id="test-l-1" class="content">
                                        <div class="text-center">
                                            <img src="<?php echo e(asset('icons/zyco.png')); ?>" style="height:75px">
                                            <p class="welcome_msg  ">Welcome to Zyco!</p>
                                            <!-- <p class="text-muted">Enter your email address or Phone Number</p>
                                            <small>Please add country code with your phone number</small> -->
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><strong>
                                                    Email*</strong></label>
                                            <input type="text" id="need_password" name="need_password" hidden
                                                value="<?php echo e($result->need_password); ?>">
                                            <input type="text" id="need_otp" name="need_otp" hidden
                                                value="<?php echo e($result->need_otp); ?>">
                                            <input type="text" class="form-control" id="email"
                                                aria-describedby="emailHelp" name="email"
                                                placeholder="Email Address or Phone Number(+31)" autofocus required>
                                            <small class="text-danger" id="email_error"></small>
                                            <div class="text-right">
                                                <small><a href="<?php echo e(route('signin_option_admin')); ?>">Can't
                                                        Login</a></small>
                                            </div>
                                            
                                            
                                        </div><br>
                                        
                                    <div class="row">
                                        <div class="col-md-6">
                                            
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button class="btn btn-primary" id="emailValidation">Next</button>
                                        </div>
                                    </div><br><br>
                                </div>
                                <div id="test-l-2" class="content">
                                    <div class="text-center">
                                        <img src="<?php echo e(asset('icons/zyco.png')); ?>" style="height:75px">
                                        <h5 style="font-weight: bolder">Sign in</h5>
                                        <p class="text-muted">Enter your password</p>
                                    </div>
                                    <div class="form-group">
                                        
                                        <input type="password" class="form-control" id="password"
                                            aria-describedby="password" name="password" onkeyup="codePasswordCheck()"
                                            placeholder="<?php echo e(trans('auth.header.password')); ?>" autofocus required>
                                        <small id="password_error" class="form-text text-red">
                                            <div class="text-right">
                                                <span><a href="<?php echo e(route('signin_option')); ?>">Can't Login</a></span>
                                            </div>
                                            <br>
                                        </small>
                                        
                                        <div id="sign-in-button"></div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-primary " onclick="stepper1.previous()"><i
                                                    class="fas fa-arrow-left"></i></button>
                                        </div>
                                        <div class="col-md-6 ">
                                            <!-- onclick="phoneSendAuth();" -->
                                            
                                            <button class="btn btn-primary float-right g-recaptcha" id="sendOtp"
                                                data-sitekey="6LdYQQ8hAAAAAH1qvC4ufbT_8nFcRIIJ6M2o8ZBG"
                                                data-callback='onSignInSubmit' data-action='submit'
                                                onclick="countdown()">Next</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <?php if($result->need_otp == "Enabled"): ?>
                                <div id="test-l-3" class="content">
                                    <div class="text-center">
                                        <img src="<?php echo e(asset('icons/zyco.png')); ?>" style="height:75px">
                                        <h4>Enter your security code</h4>
                                        <small id="sentSuccess" class="text-muted" role="alert">
                                        </small>
                                    </div>
                                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                        <input class="m-2 text-center form-control rounded" type="text"
                                            id="code_digit_1" maxlength="1" required />
                                        <input class="m-2 text-center form-control rounded" type="text"
                                            id="code_digit_2" maxlength="1" required />
                                        <input class="m-2 text-center form-control rounded" type="text"
                                            id="code_digit_3" maxlength="1" required />
                                        <input class="m-2 text-center form-control rounded" type="text"
                                            id="code_digit_4" maxlength="1" required />
                                        <input class="m-2 text-center form-control rounded" type="text"
                                            id="code_digit_5" maxlength="1" required />
                                        <input class="m-2 text-center form-control rounded" type="text"
                                            id="code_digit_6" onkeyup="codeOtpCheck()" maxlength="1" required />
                                    </div>
                                    <small class="text-danger" id="errorOtp"></small>
                                    
                                    <div class="text-right">
                                        <span class="timer">
                                            <span id="counter"></span>
                                        </span>
                                        <span id="verifiBtn"></span>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-primary " onclick="stepper1.previous()"><i
                                                    class="fas fa-arrow-left"></i></button>
                                        </div>
                                        <div class="col-md-6 ">
                                            <!-- <button class="btn btn-primary float-right"
                                                id="VerificationCodeSubmit">Next</button> -->
                                        </div>
                                    </div><br>
                                </div>
                                <?php endif; ?>
                                <div id="test-l-4" class="content">
                                    <div id="continueToDashboard"
                                        class="inputs d-flex flex-row justify-content-center mt-2">
                                        <div>
                                            <h4>All set</h4>
                                            <br>
                                            <p>You will be redirected to the Dashboard in a few seconds.</p>
                                            <button class="btn btn-primary" onclick="sendToDashboardNow()">Continue <i
                                                    class="fas fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
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
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<!-- <script src="<?php echo e(asset('assets/js/authStepper.js')); ?>"></script> -->
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
<script type="text/javascript">
var need_otp = '';
var need_password = '';
$(document).ready(function() {
    need_otp = document.getElementById('need_otp').value;
    need_password = document.getElementById('need_password').value;

});



var getMobileNumber = '';
window.onload = function() {
    render();
};

function render() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sign-in-button', {
        'size': 'invisible',
        'callback': (response) => {
            // reCAPTCHA solved, allow signInWithPhoneNumber.
            onSubmit(response);
        }
    });
    recaptchaVerifier.render();
}
$("#sendOtp").click(function() {
    grecaptcha.ready(function() {
        grecaptcha.execute('6LdoNC8hAAAAAPWtqklCfWb15h0nLIblyRMskemM', {
            action: 'submit'
        }).then(function(token) {
            // Add your logic to submit to your backend server here.
            // alert(token)
        });
    });
    var email = $('#email').val();
    var password = $('#password').val();
    if (password == "" || password == null) {
        document.getElementById('password_error').innerHTML = 'Password field is empty';
        $('#password').addClass('is-invalid');
    } else {
        $.ajax({
            type: "GET",
            url: '<?= route("check_user_exist3") ?>',
            data: {
                "_token": "<?php echo e(csrf_token()); ?>",
                table: 'admins',
                field1: 'email',
                value1: email,
                field2: 'password',
                value2: password
            },
            success: function(data) {
                if (data) {
                    if (need_otp == 'Enabled') {
                        getMobileNumber = data;
                        stepper1.next();
                        return phoneSendAuth(getMobileNumber);
                    } else {
                        getMobileNumber = data;
                        stepper1.next();
                        return loginWithoutOTP();
                    }
                } else {
                    $('#password').addClass('is-invalid');
                    document.getElementById('password_error').innerHTML =
                        'Please enter a correct password.'
                    // alert("Error");
                    // alert("Error");
                }
            },
            error: function(err) {}
        });

    }
});


function loginWithoutOTP() {
    var email = $('#email').val();
    var password = $('#password').val();
    $.ajax({
        type: "POST",
        url: '<?= route("adminLogin") ?>',
        data: {
            "_token": "<?php echo e(csrf_token()); ?>",
            email: email,
            password: password
        },
        success: function(data) {
            if (data) {
                // var user = result.user;
                // console.log(user);
                stepper1.next();
                waitToGoDashboard();
            } else {
                $('#password').addClass('is-invalid');
                document.getElementById('password_error').innerHTML =
                    'Please enter a correct password.' // alert("Error");
            }
        },
        error: function(err) {}
    });
}



function codeverify() {
    var codedigit1 = $("#code_digit_1").val();
    var codedigit2 = $("#code_digit_2").val();
    var codedigit3 = $("#code_digit_3").val();
    var codedigit4 = $("#code_digit_4").val();
    var codedigit5 = $("#code_digit_5").val();
    var codedigit6 = $("#code_digit_6").val();
    var email = $('#email').val();
    var password = $('#password').val();
    var verificationCode = codedigit1 + "" + codedigit2 + "" + codedigit3 + "" + codedigit4 + "" + codedigit5 + "" +
        codedigit6;
    // alert(verificationCode);
    var code = verificationCode;
    if (codedigit1 == '' || codedigit2 == '' || codedigit3 == '' || codedigit4 == '' || codedigit5 == '' ||
        codedigit6 == '') {
        $("#errorOtp").text("Verification code field is empty. Please insert 6 digit code properly");
        $("#errorOtp").show();
    } else {
        coderesult.confirm(code).then(function(result) {
            $(document).ready(function() {
                $.ajax({
                    type: "POST",
                    url: '<?= route("adminLogin") ?>',
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        email: email,
                        password: password
                    },
                    success: function(data) {
                        if (data) {
                            // var user = result.user;
                            // console.log(user);
                            stepper1.next();
                            waitToGoDashboard();
                        } else {
                            $('#password').addClass('is-invalid');
                            document.getElementById('password_error').innerHTML =
                                'Please enter a correct password.' // alert("Error");
                        }
                    },
                    error: function(err) {}
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
$("#VerificationCodeSubmit").click(function() {
    return codeverify();
})

function VCodeSubmit() {
    return codeverify();
}
$(document).ready(function() {
    $('#code_digit_6').keydown(function(event) {
        $("#errorOtp").text('Please wait......');
        return codeverify();
    });
});

function codeOtpCheck() {
    var codedigit1 = $("#code_digit_1").val();
    var codedigit2 = $("#code_digit_2").val();
    var codedigit3 = $("#code_digit_3").val();
    var codedigit4 = $("#code_digit_4").val();
    var codedigit5 = $("#code_digit_5").val();
    var codedigit6 = $("#code_digit_6").val();
    if (codedigit1 == null || codedigit2 == null || codedigit3 == null || codedigit4 == null || codedigit5 == null ||
        codedigit6 == null) {} else {
        $('#VerificationCodeSubmit').prop('disabled', false);
    }
}

function codePasswordCheck() {
    var passwordVal = $("#password").val();
    if (passwordVal) {
        $('#sendOtp').prop('disabled', false);
    } else {
        $('#sendOtp').prop('disabled', true);
    }
}
$("#resendOtp").click(function() {
    // alert(getMobileNumber);
    return phoneSendAuth(getMobileNumber);
})

function waitToGoDashboard() {
    setTimeout(sendToDashboardNow, 5000)
}

function phoneSendAuth(number) {
    firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {
        window.confirmationResult = confirmationResult;
        coderesult = confirmationResult;
        console.log(coderesult);
        let reg = /.{1,10}/
        $("#sentSuccess").text("Enter the code we sent to your mobile " + number.replace(reg, (m) => "X".repeat(
            m.length)));
        $("#sentSuccess").show();
    }).catch(function(error) {
        $("#error").text(error.message);
        $("#error").show();
    });
}

function sendToDashboardNow() {
    window.location.href = 'https://app.zyco.nl/adminManage/dashboard';
}
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
$("#emailValidation").click(function() {
    var emailInputFieldValue = document.getElementById('email').value;
    $('#sendOtp').prop('disabled', true);
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (emailInputFieldValue == "" || emailInputFieldValue == null) {
        document.getElementById('email_error').innerHTML = 'Email address  or phone number field is empty';
        $('#email').addClass('is-invalid');
        /*  } else if (!emailInputFieldValue.match(mailformat)) {
              document.getElementById('email_error').innerHTML = 'Invalid email address';
              $('#email').addClass('is-invalid'); */
    } else {
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: '<?= route("check_user_exist") ?>',
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    field: 'email',
                    table: 'admins',
                    value: emailInputFieldValue,
                    need: 'id'
                },
                success: function(data) {
                    if (data) {
                        stepper1.next();
                    } else {
                        document.getElementById('email_error').innerHTML =
                            'This email address or phone number is not exists';
                        $('#email').addClass('is-invalid');
                    }
                },
                error: function(err) {
                    document.getElementById('email_error').innerHTML =
                        err;
                    $('#email').addClass('is-invalid');
                }
            });
        });
    }
})

function onSubmit(token) {
    //   alert(token);
    document.getElementById("demo-form").submit();
}
$(document).ready(function() {
    $('#emailValidation').prop('disabled', true);
    $('#email').on('input', function() {
        var val = $('#email').filter(function() {
            return this.value.trim().length !== 0;
        }).length === 0;
        $('#emailValidation').prop('disabled', val);
    });
    document.getElementById("sendOtp").disabled = true;
    //$('#sendOtp').prop('disabled', true);
    /* $('#password').on('input', function() {
         var val = $('#password').filter(function() {
             return this.value.trim().length !== 0;
         }).length === 0;
         $('#sendOtp').prop('disabled', val);
     });*/
    $('#VerificationCodeSubmit').prop('disabled', true);
    $('#code_digit_1').on('input', function() {
        var val = $('#code_digit_1').filter(function() {
            return this.value.trim().length !== 0;
        }).length === 0;
    });
    $('#code_digit_2').on('input', function() {
        var val = $('#code_digit_2').filter(function() {
            return this.value.trim().length !== 0;
        }).length === 0;
    });
    $('#code_digit_3').on('input', function() {
        var val = $('#code_digit_3').filter(function() {
            return this.value.trim().length !== 0;
        }).length === 0;
    });
    $('#code_digit_4').on('input', function() {
        var val = $('#code_digit_4').filter(function() {
            return this.value.trim().length !== 0;
        }).length === 0;
    });
    $('#code_digit_5').on('input', function() {
        var val = $('#code_digit_5').filter(function() {
            return this.value.trim().length !== 0;
        }).length === 0;
    });
    $('#code_digit_6').on('input', function() {
        var val = $('#code_digit_6').filter(function() {
            return this.value.trim().length !== 0;
        }).length === 0;
        $('#VerificationCodeSubmit').prop('disabled', val);
    });
});

function countdown() {
    var seconds = 59;

    function tick() {
        var counter = document.getElementById("counter");
        seconds--;
        counter.innerHTML =
            "0:" + (seconds < 10 ? "0" : "") + String(seconds);
        if (seconds > 0) {
            setTimeout(tick, 1000);
        } else {
            document.getElementById("verifiBtn").innerHTML =
                '<small><a id="resendOtp" href="#">Resend Code</a></small>';
            document.getElementById("counter").innerHTML = "";
        }
    }
    tick();
}
// countdown();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Dream\Laravel Deep Learning\zyco\resources\views/auth/admin_login.blade.php ENDPATH**/ ?>