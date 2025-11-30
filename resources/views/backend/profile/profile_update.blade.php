@extends('backend.web_admin')
@section('content')

<link rel="stylesheet" href="{{asset('assets/css/user-profile-update.css')}}" />


<div class="content-wrapper ">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->
    <!-- Main content -->
    <!-- Default box -->

    <div class="m-4">
        <div class="card  pt-3 pl-3 pr-3 pb-0 ">
            @include('backend.common.my_profile2')

            <ul class="nav nav-tabs" id="myTab" id="custom-tabs-five-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-five-settings-tab" data-toggle="pill" role="tab"
                        aria-controls="custom-tabs-five-settings" aria-selected="true" href="#overview">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-settings-tab" data-toggle="pill" role="tab"
                        aria-controls="custom-tabs-five-settings" aria-selected="false"
                        href="#documentInfo">Documents</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-settings-tab" data-toggle="pill" role="tab"
                        aria-controls="custom-tabs-five-settings" aria-selected="false" href="#companyInfo">Company
                        Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-settings-tab" data-toggle="pill" role="tab"
                        aria-controls="custom-tabs-five-settings" aria-selected="false" href="#bankInfo">Bank Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-settings-tab" data-toggle="pill" role="tab"
                        aria-controls="custom-tabs-five-settings" aria-selected="false" href="#vehicleInfo">Vehicle</a>
                </li>



            </ul>
        </div>
        <div class="card">
            <div class="tab-content ">
                <div class="tab-pane fade  show active " role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab"
                    id="overview">
                    @include('backend.profile.overview')
                </div>

                <div class="tab-pane fade" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab"
                    id="documentInfo">
                    @include('backend.document.index')
                </div>


                <div class="tab-pane fade" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab"
                    id="companyInfo">
                    @include('backend.company.index')
                </div>
                <div class="tab-pane fade" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab" id="bankInfo">
                    @include('backend.profile.bank_update')
                </div>
                <div class="tab-pane fade" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab"
                    id="vehicleInfo">
                    @include('backend.drivers_vehicle.index')
                </div>
            </div>
        </div>
    </div>

    <!-- Tab panes -->






    <script>
    $(document).ready(function() {
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
    });
    </script>
    @endsection