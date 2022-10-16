@extends('backend.web_admin')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="ml-5">
        <div class="tab-content-heading-div">
            <div class="row">
                <div class="col-md-6">
                    <div class="tab-content-heading">Login Configuration</div>
                    <div class="tab-content-muted-text">Manage Login Configuration
                    </div>
                </div>
                <!-- <div class="col-md-6 d-flex justify-content-end">
                    <button class="btn btn-primary  edit-profile-button ">
                        <div class="edit-profile-button-text m-1 addform" data-toggle="modal"
                            data-target="#addClassificationPackages">
                            Create New
                        </div>
                    </button>
                </div> -->
            </div>
            <hr />
            <br>
            <table class="table">
                <tr>
                    <th>Id</th>
                    <th>Login Type</th>
                    <th>OTP</th>
                    <th>Password</th>
                </tr>
                @foreach($result as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>{{$row->login_type}}</td>

                    <td>
                        <div class="dropdown">
                            <button @if ($row->need_password == 'Enabled')
                                class="btn btn-outline-success dropdown-toggle rounded-pill"
                                @else
                                class="btn btn-outline-danger dropdown-toggle rounded-pill"
                                @endif class="btn btn-outline-danger dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{$row->need_password}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="statusChange">
                                <button class="dropdown-item"
                                    onclick="updateSingleData('<?php echo $row->id; ?>','login_config','need_password','Enabled')">Enabled</button>
                                <button class="dropdown-item"
                                    onclick="updateSingleData('<?php echo $row->id; ?>','login_config','need_password','Disabled')">Disabled</button>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button @if ($row->need_otp == 'Enabled')
                                class="btn btn-outline-success dropdown-toggle rounded-pill"
                                @else
                                class="btn btn-outline-danger dropdown-toggle rounded-pill"
                                @endif class="btn btn-outline-danger dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{$row->need_otp}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="statusChange">
                                <button class="dropdown-item"
                                    onclick="updateSingleData('<?php echo $row->id; ?>','login_config','need_otp','Enabled')">Enabled</button>
                                <button class="dropdown-item"
                                    onclick="updateSingleData('<?php echo $row->id; ?>','login_config','need_otp','Disabled')">Disabled</button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
            <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#adminlogin" role="tab"
                        aria-controls="home" aria-selected="true">Admin Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#userlogin" role="tab"
                        aria-controls="profile" aria-selected="false">User Login</a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="adminlogin" role="tabpanel" aria-labelledby="home-tab">

                </div>
                <div class="tab-pane fade" id="userlogin" role="tabpanel" aria-labelledby="profile-tab">

                </div>
            </div> -->

        </div>
    </div>

    <div class="modal fade addform" id="addClassificationPackages" tabindex="-1" role="dialog"
        aria-labelledby="addformTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    @include('backend.account_classification_package.add')
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card elevation-0">
                    <div class="card-header bg-default">
                        <h4>Details</h4>
                    </div>
                    <div class="card-body bg-default" id="detailsData">

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<script>
function showClassificationDetails(id, table_name) {
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: '<?= route("getDetails") ?>',
            data: {
                id: id,
                table_name: table_name
            },
            success: function(data) {
                $('#detailsModal').modal('show');
                var detailsDiv = document.getElementById("detailsData");
                detailsDiv.innerHTML =
                    '<div class="card"> <div class="card-header">Classification</div><table class="table "> <tr><td>ID</td><td>:</td><td>' +
                    data.$detailsData[0].id +
                    '</td></tr><tr><td>Classifi</td><td>:</td><td>' +
                    data.$detailsData[0].classification_name +
                    '</td></tr><tr><td>Price</td><td>:</td><td>' +
                    data.$detailsData[0].price +
                    '</td></tr><tr><td>Status</td><td>:</td><td>' +
                    data.$detailsData[0].status +
                    '</td></tr></table></div>';
            },
            error: function(data) {}
        });
    });
}
</script>
@endsection