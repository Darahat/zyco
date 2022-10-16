 <style>
.image-upload>input {
    display: none;
}
 </style>
 <div class="tab-content-heading-div">
     <div class="row">
         <div class="col-md-6">
             <div class="tab-content-heading">Vehicle Classification Type</div>
             <div class="tab-content-muted-text">Manage all of your vehicle classification type
             </div>
         </div>
         <div class="col-md-6 d-flex justify-content-end">
             <button class="btn btn-primary  edit-profile-button ">
                 <div class="edit-profile-button-text m-1 addform" data-toggle="modal"
                     data-target="#vehicleclassificationsetup">Add
                     New
                 </div>
             </button>
         </div>
     </div>
     <hr />
     <br>
     <table class="table table-sm datatable2" id="">
         <thead>
             <tr>
                 <th>View</th>
                 <th>Action</th>
                 <th>Id</th>
                 <th>Name</th>
                 <th>Badge</th>
                 <th>Status</th>
             </tr>
         </thead>
         <tbody>
             @foreach($vehicles_classification as $row)
             <tr>
                 <td>
                     <a class="btn btn-default shadow-none"
                         onClick="showClassificationDetails(<?php echo $row->id; ?>,'vehicle_classification')">
                         <i class="fa fa-eye"></i>
                     </a>
                 </td>
                 <td class="notToggleVis">
                     <div class="btn-group">

                         <div class="dropdown">
                             <button class="btn btn-default dropdown-toggle shadow-small" type="button"
                                 id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false">
                             </button>
                             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                 <a class="dropdown-item"
                                     href="{{ url('/admin/edit_vehicle_classification/'.$row->id)}}"><i
                                         class="fa fa-edit"></i> Edit</a>
                                 <a class="dropdown-item"
                                     href="{{ url('/admin/delete_vehicle_classification/'.$row->id)}}"><i
                                         class="fa fa-trash"></i> Delete</a>
                             </div>
                         </div>
                     </div>
                 </td>
                 <td>{{$row->id}}</td>

                 <td>
                     <div class="row">
                         <div class="col-md-3">
                             {{$row->classification_name}}
                         </div>
                         <div class="col-md-3">
                             <div class="dropdown">
                                 <button class="btn  btn-outline-default btn-sm dropdown-toggle rounded-pill"
                                     type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                     <i class="fa-solid fa-pen-to-square">
                                     </i>
                                 </button>
                                 </label>
                                 <div class="dropdown-menu">
                                     <div class="card">
                                         <div class="card-body p-3">
                                             <form method="post" action="{{route('updateSingleData')}}"
                                                 enctype="multipart/form-data">
                                                 @csrf
                                                 <div class="image-upload">
                                                     <label for="file-input">
                                                         <input type="text" name="value" id="value" class="form-control"
                                                             placeholder="Name" required>
                                                     </label>
                                                 </div>
                                                 <input type="text" name="field" id="field" hidden
                                                     value="classification_name">
                                                 <input type="text" name="table" id="table" hidden
                                                     value="vehicle_classification">
                                                 <input type="text" name="id" id="id" hidden value="{{$row->id}}">
                                                 <div class="d-flex justify-content-center">
                                                     <button type="submit" class="btn btn-primary">Save</button>
                                                 </div>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </td>
                 <td>
                     <div class="dropdown">
                         <img src="{{asset('public/vehicle_classification/'.$row->badge_icon)}}" alt=""
                             style="height: 40px">
                         <button class="btn  btn-outline-default btn-sm dropdown-toggle rounded-pill" type="button"
                             id="uploadImage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <i class="fa-solid fa-pen-to-square"></i>
                         </button>
                         </label>
                         <div class="dropdown-menu" aria-labelledby="uploadImage">
                             <div class="card">
                                 <div class="card-body p-3">
                                     <form method="post" action="{{route('imageChange')}}"
                                         enctype="multipart/form-data">
                                         @csrf
                                         <div class="image-upload">
                                             <label for="file-input">
                                                 <input type="file" name="image" id="image" class="form-control"
                                                     placeholder="image" required>
                                             </label>
                                         </div>
                                         <input type="text" name="field" id="field" hidden value="badge_icon">
                                         <input type="text" name="table_name" id="table_name" hidden
                                             value="vehicle_classification">
                                         <input type="text" name="id" id="id" hidden value="{{$row->id}}">
                                         <div class="d-flex justify-content-center">
                                             <button type="submit" class="btn btn-primary">Save</button>
                                         </div>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </td>
                 <td>
                     <div class="dropdown">
                         <button @if ($row->status == 'Active')
                             class="btn btn-outline-success dropdown-toggle rounded-pill"
                             @else
                             class="btn btn-outline-danger dropdown-toggle rounded-pill"
                             @endif class="btn btn-outline-danger dropdown-toggle" type="button"
                             id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                             aria-expanded="false">
                             {{$row->status}}
                         </button>
                         <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="statusChange">
                             <button class="dropdown-item"
                                 onclick="updateSingleData('<?php echo $row->id; ?>','vehicle_classification','status','Active')">Active</button>
                             <button class="dropdown-item"
                                 onclick="updateSingleData('<?php echo $row->id; ?>','vehicle_classification','status','Inactive')">Inactive</button>
                         </div>
                     </div>
                 </td>

             </tr>
             @endforeach


         </tbody>
     </table>


 </div>



 <div class="modal fade addform" id="vehicleclassificationsetup" tabindex="-1" role="dialog"
     aria-labelledby="addformTitle" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-body">
                 @include('backend.vehicle_classification.add')
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
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
                    '</td></tr><tr><td>Name</td><td>:</td><td>' +
                    data.$detailsData[0].classification_name +
                    '</td></tr><tr><td>Badge Icon</td><td>:</td><td> <img alt=""  style="height: 40px" src="https://ihostbd.net/taxi_plaza/public/vehicle_classification/' +
                    data.$detailsData[0].badge_icon +
                    '"></td></tr><tr><td>Status</td><td>:</td><td>' +
                    data.$detailsData[0].status +
                    '</td></tr></table></div>';

                //   else  if(table_name == 'vehicle_type'){
                //     adminDetailsDiv.innerHTML = '<div class="card"> <div class="card-header">Type</div><table class="table "> <tr><td>ID</td><td>:</td><td>'
                //   +data.$detailsData[0].id+
                //   '</td></tr><tr><td>Type Name</td><td>:</td><td>'
                //   +data.$detailsData[0].vehicle_type_name+
                //   '</td></tr><tr><td>Description</td><td>:</td><td>'
                //   +data.$detailsData[0].description+
                //   '</td></tr><tr><td>Classification Name</td><td>:</td><td>'
                //   +data.$detailsData[0].vehicle_classification_id	+
                //   '</td></tr><tr><td>Status</td><td>:</td><td>'
                //   +data.$detailsData[0].status+
                //    '</td></tr></table></div>';
                // },
            },
            error: function(data) {}
        });
    });
}
 </script>