 <!-- Main content -->


 <!-- Button trigger modal -->


 <form action="{{route('updatePersonal')}}" method="post" enctype="multipart/form-data">
     @csrf
     <?php


        $bsn_number = $personalInfo->bsn_number ?? '';
        $passport_number = $personalInfo->passport_number ?? '';
        $name_title = $personalInfo->name_title ?? '';
        $first_name = $personalInfo->first_name ?? '';
        $last_name = $personalInfo->last_name ?? '';
        $sur_name = $personalInfo->sur_name ?? '';
        $mobile_number = $personalInfo->mobile_number ?? '';
        $email_address = $personalInfo->email_address ?? '';
        $street_name = $personalInfo->street_name ?? '';
        $post_code = $personalInfo->post_code ?? '';
        $county = $personalInfo->county ?? '';
        $country = $personalInfo->country ?? '';
        $language = $personalInfo->language ?? '';
        $date_of_birth = $personalInfo->date_of_birth ?? '';
        $profile_picture = $personalInfo->profile_picture ?? '';
        $note_area = $personalInfo->note_area ?? '';
        $row_id = $personalInfo->id ?? '';
        ?>
     <div class="row">


         <div class="col-md-6 col-lg-6">
             <div class="form-group">
                 <label class="control-label input-box-label ">Name Title<em class="text-danger"></em></label>
                 <input type="text" name="name_title" placeholder="name_title" id="name_title" value="{{ $name_title }}"
                     class="form-control input-box">
             </div>
         </div>
         <div class="col-md-6 col-lg-6">
             <div class="form-group">
                 <label class="control-label input-box-label">First Name<em class="text-danger">*</em></label>
                 <input type="text" name="first_name" placeholder="first_name" id="first_name" value="{{ $first_name }}"
                     class="form-control input-box" required>
             </div>
         </div>



         <div class="col-md-6 col-lg-6">
             <div class="form-group">
                 <label class="control-label input-box-label">Last Name<em class="text-danger">*</em></label>
                 <input type="text" name="last_name" placeholder="last_name" id="last_name" value="{{ $last_name }}"
                     class="form-control input-box" required>
             </div>
             <label class="control-label input-box-label">Driving Licence<em class="text-danger">*</em></label>
             <input type="text" name="last_name" placeholder="last_name" id="last_name" value="{{ $last_name }}"
                 class="form-control input-box" required>
         </div>
         < div class="pb-2 row">
             <div class="col-md-6 col-lg-6">
                 <label class="control-label input-box-label">Personal Number<em class="text-danger">*</em></label>
                 <input type="text" name="mobile_number" placeholder="mobile_number" id="mobile_number"
                     value="{{ $mobile_number }}" class="form-control input-box" required>
             </div>
             <div class="col-md-6 col-lg-6">
                 <label class="control-label input-box-label">Personal Email<em class="text-danger"></em></label>
             </div>

             <input type="text" name="email_address" placeholder="email_address" id="email_address"
                 value="{{ $email_address }}" class="form-control input-box">
         </>
         <div class="col-md-6 col-lg-6">
             <label class="control-label input-box-label">Emergency Number<em class="text-danger"></em></label>
         </div>

         <input type="text" name="email_address" placeholder="email_address" id="email_address"
             value="{{ $email_address }}" class="form-control input-box">
     </div>
     </div>

     <div class="pb-2 row">
         <div class="col-md-6 col-lg-6">
             <label class="control-label input-box-label">Address<em class="text-danger"></em></label>
         </div>

         <input type="text" name="street_name" placeholder="street_name" id="street_name" value="{{ $street_name }}"
             class="form-control input-box">
     </div>

     </div>
     <div class="pb-2 row">
         <div class="col-md-6 col-lg-6">
             <label class="control-label input-box-label">County Name<em class="text-danger">*</em></label>
         </div>

         <input type="text" name="county" placeholder="county" id="county" value="{{ $county }}"
             class="form-control input-box" required>
     </div>
     <div class="col-md-6 col-lg-6">
         <label class="control-label input-box-label">Country Name<em class="text-danger">*</em></label>
     </div>

     <input type="text" name="country" placeholder="country" id="country" value="{{ $country }}"
         class="form-control input-box" required>
     </div>
     </div>

     <div class="pb-2 row">

         <div class="col-md-6 col-lg-6">
             <label class="control-label input-box-label">Date of Birth<em class="text-danger"></em></label>
         </div>
         <div class="col-md-6 col-lg-6">
             <input type="date" name="date_of_birth" placeholder="date_of_birth" id="date_of_birth"
                 value="{{ $date_of_birth }}" class="form-control input-box">
         </div>
     </div>

     <div class="pb-2 row">

         <div class="col-md-6 col-lg-6">
             <label class="control-label input-box-label">Note<em class="text-danger"></em></label>
         </div>
         <div class="col-md-6 col-lg-6">
             <textarea name="note_area" placeholder="note_area" id="note_area"
                 class="form-control input-box">{{ $note_area }}</textarea>
         </div>
     </div>
     </div>
     <div class="pb-2 row">
         <div class="col-md-6 col-lg-6"></div>
         <div class="col-md-6 col-lg-6">
             <input type="hidden" name="id" value="{{ $row_id }}">
             <button type="submit" class="btn btn-primary btn-sm">Submit</button>
         </div>
     </div>



 </form>