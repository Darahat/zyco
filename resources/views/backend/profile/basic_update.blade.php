@extends('backend.web_admin')
@section('content')

<link rel="stylesheet" href="{{asset('public/assets/css/user-profile-update.css')}}" />


<div class="content-wrapper ">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->
    <!-- Main content -->
    <!-- Default box -->

    <div class="m-4">

        <?php
        if (!empty($basicInfo)) :

            $id = $basicInfo->id;
            $username = $basicInfo->username;
            $email = $basicInfo->email;
            $mobile_number = $basicInfo->mobile_number;
            $password = $basicInfo->password;
            $alt_email = $basicInfo->alt_email;
            $base_city = $basicInfo->base_city;
            $can_speak = explode(',', $basicInfo->can_speak);
            $time_zone = $basicInfo->time_zone;
            $language = $basicInfo->language;
            $row_id = $basicInfo->id;

        else :
            $id = "";
            $username = "";
            $email = "";
            $mobile_number = "";
            $password = "";
            $alt_email = "";
            $base_city = "";
            $can_speak = [];
            $time_zone = "";
            $language = "";
            $note_area = "";
            $row_id = "";
        endif;


        if (!empty($personalInfo)) :

            $profile_picture = $personalInfo->profile_picture;
            $personalInfoId = $personalInfo->id;

        else :
            $profile_picture = "";
            $personalInfoId = "";
        endif;

        ?>


        <input type="text" name="table" id="table" hidden value="users">

        <input type="text" name="id" id="id" hidden value="{{$id ?? ''}}">
        <div class="card">
            <div class="tab-content-heading-div">
                <div class="row">
                    <div class="col-md-6">
                        <div class="tab-content-heading">Profile Settings</div>
                        <div class="tab-content-muted-text">Manage all of your Profile Informations
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <button class="btn btn-primary  edit-profile-button ">
                            <div class="edit-profile-button-text m-1 addform" data-toggle="modal"
                                data-target="#addvehicle">Add
                                New
                            </div>
                        </button>
                    </div>
                </div>
                <hr />
                <br>
                <div class="row">

                    <div class="col-md-12 profile-setting-form-partial-headline mb-5 pl-3">
                        <p>Update Password</p>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <small id="new_pass_error" class="text-danger"></small>
                            <label for="passenger_capacity" class="col-sm-12 control-label input-box-label">Current
                                Password<em class="text-danger">*</em></label>
                            <div class="col-md-12 col-sm-offset-1">
                                <input type="password" class="form-control input-box" type="password"
                                    name="current_password" id="current_password" required>
                                <span class="text-danger">{{ $errors->first('current_password') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <small id="new_pass_error" class="text-danger"></small>
                            <label for="passenger_capacity" class="col-sm-12 control-label input-box-label">New
                                Password<em class="text-danger">*</em></label>
                            <div class="col-md-12 col-sm-offset-1">
                                <input type="password" class="form-control input-box" type="password" name="password"
                                    id="password" required>
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <button id="updatePassword" class="btn  submit-button ml-3">Submit</button>
                        </div>
                    </div>
                    <div class="col-md-12 profile-setting-form-partial-headline mb-5 pl-3">
                        <p>Language</p>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">

                            <label for="passenger_capacity" class="col-sm-12 control-label input-box-label">Language<em
                                    class="text-danger">*</em></label>
                            <div class="col-md-12 col-sm-offset-1">

                                <select class=" form-control input-box" name="language" id="language">

                                    <option value="">----Select---</option>
                                    <?php
                                    if (!empty($languagelist)) :
                                    ?>
                                    @foreach($languagelist as $row1)
                                    <option value="{{$row1->value ?? ''}}" @if($language==$row1->value) selected @endif
                                        >{{$row1->name}}</option>
                                    @endforeach
                                    <?php
                                    endif;
                                    ?>
                                </select>
                                <span class="text-danger">{{ $errors->first('passenger_capacity') }}</span>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <button id="updatelanguage" class="btn  submit-button ml-3"
                                onclick="updateSingleDataGeneralInfo('language')">Submit</button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">

                            <label for="can_speak" class="col-sm-12 control-label input-box-label">Can Speak<em
                                    class="text-danger">*</em></label>
                            <div class="col-sm-12">
                                <select class="js-example-basic-multiple form-control input-box" name="can_speak[]"
                                    id="can_speak" multiple="multiple">
                                    <option value="">----Select---</option>
                                    <?php
                                    if (!empty($languagelist)) :
                                    ?>
                                    @foreach($languagelist as $row)
                                    @foreach($can_speak as $row1)
                                    <option value="{{$row->value ?? ''}}" @if($row->value == $row1) selected @endif
                                        >{{$row->name}}
                                    </option>
                                    @endforeach
                                    @endforeach
                                    <?php
                                    endif;
                                    ?>
                                </select>
                                <br>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <button id="updateCanSpeak" class="btn  submit-button ml-3"
                                onclick="updateSingleArrayDataGeneralInfo('can_speak')">Submit</button>
                        </div>
                    </div>

                    <div class="col-md-12 profile-setting-form-partial-headline mb-5 pl-3">
                        <p>Contact Information</p>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label input-box-label">Email address </label><br>

                            <div class="col-sm-12">
                                <input type="email" name="email" placeholder="Your Current Password is :  {{$email}} "
                                    id="email" class="form-control input-box" required>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <button id="updateEmail" class="btn  submit-button ml-3"
                                onclick="updateSingleDataGeneralInfo('email')">Submit</button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label input-box-label">Alternative Email</label>

                            <div class="col-sm-12">
                                <input type="email" name="alt_email" placeholder="alt_email" id="alt_email"
                                    value="{{ $alt_email ?? '' }}" class="form-control input-box" required>
                            </div>
                            <br>
                            <div style="text-align: right;">
                                <button id="updateAltEmail" class="btn  submit-button ml-3"
                                    onclick="updateSingleDataGeneralInfo('alt_email')">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label input-box-label">Mobile Number</label>
                            <div class="col-sm-12">
                                <input type="text" name="mobile_number" placeholder="mobile_number"
                                    pattern="/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im" value="+31"
                                    id="mobile_number" class="form-control input-box" required>
                            </div>
                            <br>
                            <div style="text-align: right;">
                                <button id="updateMobile" class="btn  submit-button ml-3"
                                    onclick="updateSingleDataGeneralInfo('mobile_number')">Submit</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label input-box-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" name="username" placeholder="username" id="username"
                                    value="{{ $username ?? '' }}" class="form-control input-box" required>

                            </div>
                            <br>
                            <div style="text-align: right;">
                                <button id="updateUsername" class="btn  submit-button ml-3"
                                    onclick="updateSingleDataGeneralInfo('username')">Submit</button>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-6 col-lg-6">
                        <div class="col-md-12 profile-setting-form-partial-headline mb-5 pl-3">
                            <p>Base City</p>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label input-box-label">Base City</label>
                                <div class="col-sm-12">
                                    <input type="text" name="base_city" placeholder="base_city" id="base_city"
                                        value="{{ $base_city?? '' }}" class="form-control input-box" required>

                                    <br>
                                    <div style="text-align: right;">
                                        <button id="updatebasecity" class="btn  submit-button ml-3"
                                            onclick="updateSingleDataGeneralInfo('base_city')">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="col-md-12 profile-setting-form-partial-headline mb-5 pl-3">
                            <p>Time Zone</p>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label input-box-label">Time Zone </label>
                                <div class="col-sm-12">
                                    @if($time_zones)
                                    <select name="time_zone" placeholder="time_zone" id="time_zone"
                                        value="{{ $time_zone ?? ''}}" class="form-control input-box" required>
                                        @foreach($time_zones as $zone)
                                        <option @if($zone->value == $time_zone) selected @endif
                                            value="{{$zone->value ?? ''}}">{{$zone->label}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <div style="text-align: right;">
                                        <button id="updateCanSpeak" class="btn  submit-button ml-3"
                                            onclick="updateSingleDataGeneralInfo('time_zone')">Submit</button>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>








































                </div>
            </div>





            <div class="pb-2 row">
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id}}">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </div>


        </div>





        <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
        <!-- <script src="{{ asset('public/assets/js/authStepper.js') }}"></script> -->
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
        <script>
        function updateSingleArrayDataGeneralInfo(field) {

            var table = $('#table').val();
            var id = $('#id').val();
            var value = $("#" + field).val();
            if (table == null || table == '') {
                swal(
                    'Table name is empty!!',
                    'error')
            } else if (id == null || id == '') {
                swal(
                    'User data not found!!',
                    'error')
            } else if (value == null || value == '') {
                swal(
                    'Input Field is empty!!',
                    'error')
            } else {
                $.ajax({
                    type: "POST",
                    url: '<?= route("updateSingleArrayData") ?>',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        field: field,
                        table: table,
                        value: value,
                        id: id,
                    },
                    success: function(data) {
                        swal(
                            'Data Updated Sucessfully!!',

                            'success'
                        ).then((value) => {
                            location.reload();
                        });
                    },
                    error: function(err) {

                    }

                });
            }
        }


        function updateSingleDataGeneralInfo(field) {

            var table = $('#table').val();
            var id = $('#id').val();
            var value = $("#" + field).val();
            if (table == null || table == '') {
                swal(
                    'Table name is empty!!',
                    'error')
            } else if (id == null || id == '') {
                swal(
                    'User data not found!!',
                    'error')
            } else if (value == null || value == '') {
                swal(
                    'Input Field is empty!!',
                    'error')
            } else {
                $.ajax({
                    type: "POST",
                    url: '<?= route("updateSingleData") ?>',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        field: field,
                        table: table,
                        value: value,
                        id: id,
                    },
                    success: function(data) {
                        swal(
                            'Data Updated Sucessfully!!',

                            'success'
                        ).then((value) => {
                            location.reload();
                        });
                    },
                    error: function(err) {

                    }

                });
            }
        }
        $("#updatePassword").click(function() {
            var mobile_number = ''
            // stepper1.next();
            var current_password = $('#current_password').val();
            var password = $('#password').val();
            var confirmPassword = $('#confirmPassword').val();
            var user_id = $('#user_id').val();

            if (password == "" || password == null) {
                $("#new_pass_error").text("Password field is empty");
                $('#password').addClass('is-invalid');
                $("#new_pass_error").show();

            }
            //  else if (confirmPassword != password) {
            //     $("#new_pass_error").text("Your provided password is not matching with confirm password");
            //     $('#password').addClass('is-invalid');
            //     $('#confirmPassword').addClass('is-invalid');
            //     $("#new_pass_error").show();
            // } 
            else {

                $(document).ready(function() {


                    $.ajax({
                        type: "GET",
                        url: '<?= route("check_user_exist3") ?>',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            field2: 'password',
                            field1: 'id',
                            table: 'users',
                            value2: current_password,
                            value1: user_id,
                        },
                        success: function(data) {
                            if (data) {
                                mobile_number = data;
                                $.ajax({
                                    type: "POST",
                                    url: '<?= route("updateAuthData") ?>',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        field: 'password',
                                        table: 'users',
                                        value: password,
                                        mobile_number: data
                                    },
                                    success: function(data) {
                                        if (data) {

                                            swal(
                                                'Password Changed Sucessfully!!',

                                                'success'
                                            ).then((value) => {
                                                location
                                                    .reload();
                                            });


                                        } else {

                                            // stepper1.previous();
                                            document.getElementById(
                                                    'new_pass_error')
                                                .innerHTML =
                                                'Current password is wrong. Password Update failed'
                                        }
                                    },
                                    error: function(err) {

                                    }
                                });
                            } else {


                                document.getElementById('new_pass_error').innerHTML =
                                    'Current password is wrong. Password Update failed'
                            }
                        },
                        error: function(err) {

                        }
                    });






                });
            }

        })

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
        </script>
        @endsection