@extends('backend.web_admin')
@section('content')

<div class="content-wrapper ">
    <div class="m-4">
        <div class="card  pt-3 pl-3 pr-3 pb-0 ">
            <div class="row">
                <div class="col-md-6">
                    <div class="tab-content-heading">Vehicles Configuration</div>
                    <div class="tab-content-muted-text">Manage Vehicle Details Configuration
                    </div>
                </div>
            </div>
            <hr />
            <br>
            <ul class="nav nav-tabs" id="myTab">
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#classification">Classification</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#type">Type</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#make">Make</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#model">Model</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content p-3">
                <div class="tab-pane  active" id="classification">
                    @include('backend.vehicle_classification.index')
                </div>
                <div class="tab-pane  fade" id="type">
                    @include('backend.vehicle.vehicle_type')
                </div>
                <div class="tab-pane  fade" id="make">
                    @include('backend.vehicle.vehicle_make')
                </div>
                <div class="tab-pane  fade" id="model">
                    @include('backend.vehicle.vehicle_model')
                </div>

            </div>
        </div>
    </div>

</div>
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