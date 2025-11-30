 <div class="tab-content-heading-div">

     <div class="tab-content-heading">Personal
         information</div>
     <div class="tab-content-muted-text">Home-User Profile
     </div>
     <hr />
     <br>
     <div>

         @if(empty($personalInfo->profile_picture))
         <img class="avatar-edit" id="avatar" src="{{ asset('icons/avatar1.png') }} " alt="Avatar">
         @else
         <img class="avatar-edit" id="avatar"
             src="{{ asset('users_personalinfo/'.$personalInfo->profile_picture) }} " alt="Avatar">
         @endif

         <div class="avatar-edit-btn justify-content-center" data-toggle="modal" data-target="#profilepicturemodal">
             <i class="fa fa-pencil  "></i>
         </div>

         <div class="avatar-delete-btn justify-content-center">
             <i class="fa fa-xmark"></i>
         </div>
     </div>
     <div class="tab-content-muted-text">Allowed file types: png, jpg, jpeg.
     </div>
     <div class="mt-5">
         @include('backend.profile.personal_info')
     </div>

 </div>
 <div class="modal fade" id="profilepicturemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Upload Profile Photo</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="{{route('imageChange')}}" method="post" enctype="multipart/form-data">
                 @csrf
                 <div class="modal-body">
                     <input type="text" hidden value="profile_picture" name="field">
                     <input type="text" hidden value="users_personalinfo" name="table_name">
                     <input type="text" hidden value="{{$personalInfo->id}}" name="id">
                     @if(empty($personalInfo->profile_picture))
                     <img class="avatar-edit" id="avatar" src="{{ asset('icons/avatar1.png') }} " alt="Avatar">
                     @else
                     <img class="avatar-edit" id="avatar"
                         src="{{ asset('users_personalinfo/'.$personalInfo->profile_picture) }} " alt="Avatar">
                     @endif
                     <input type="file" name="image" id="image">
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Save changes</button>
                 </div>
             </form>
         </div>
     </div>
 </div>