 <div class="row p-2 profile-upper-portion mb-2">
     <div class="col-2 h-100 d-flex  align-items-center justify-content-center">
         <?php if(empty($personalInfo->profile_picture)): ?>
         <img class="img-fluid  img-thumbnail user-image" id="avatar" src="<?php echo e(asset('icons/avatar1.png')); ?> "
             alt="Avatar">
         <?php else: ?>
         <img class=" img-fluid img-thumbnail user-image" id="avatar"
             src="<?php echo e(asset('users_personalinfo/'.$personalInfo->profile_picture)); ?> " alt="Avatar">
         <?php endif; ?>
     </div>
     <div class="col-6 ">
         <div class="user-name">
             <?php echo e($basicInfo->first_name); ?> <?php echo e($basicInfo->last_name); ?>

         </div>
         <div class="row pt-2 ">
             <div class="col-2">
                 <i class="fa fa-user-tie profile-upper-portion-icon "></i> <span
                     class="text-muted profile-upper-portion-user-details-text"><?php echo e($basicInfo->user_type ?? 'Not Updated'); ?></span>
             </div>
             <div class="col-5">
                 <i class="fas fa-location-dot profile-upper-portion-icon "></i> <span
                     class="text-muted profile-upper-portion-user-details-text"><?php echo e($personalInfo->street_name ?? 'Not Updated'); ?></span>
             </div>
             <div class="col-4">
                 <i class="fas fa-phone profile-upper-portion-icon "></i> <span
                     class="text-muted profile-upper-portion-user-details-text"><?php echo e($basicInfo->mobile_number ?? 'Not Updated'); ?></span>
             </div>
             <div class="col">
             </div>
         </div>
         <div class="row mt-4">
             <div class="col  profile-upper-portion-amount-div mr-3  " style="text-align:center">
                 <strong class="profile-upper-portion-amount"> $4500 </strong>
                 <div class="profile-upper-portion-text">Earning </div>
             </div>
             <div class="col   profile-upper-portion-amount-div mr-3 " style="text-align:center">
                 <strong class="profile-upper-portion-amount"> 275 </strong>
                 <div class="profile-upper-portion-text"> Requests </div>
             </div>
             <div class="col  profile-upper-portion-amount-div mr-3  " style="text-align:center">
                 <strong class="profile-upper-portion-amount">60%</strong>
                 <div class="profile-upper-portion-text"> Success Rate </div>
             </div>
         </div>
     </div>

     <div class="col-4">
         <div class="row">
             <div class="col-6  mb-5"> <i class="fa-solid fa-gear" style="color:#95A1AF;width:1.198vw"></i> <a
                     class="text-muted profile-setting">Profile Setting</a> </div>
             <div class="col-6 mb-5 "><button class="btn btn-primary  edit-profile-button">
                     <div class="edit-profile-button-text">Edit Profile</div>
                 </button> </div>
             <div class="col-6   upgradation-progress-text"> Profile Compilation </div>
             <div class="col-6  text-right upgradation-progress-text ">20%</div>
             <div class="col-12 mt-1">
                 <div class="progress" style="height: 4px;">
                     <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                         aria-valuemin="0" aria-valuemax="100"></div>
                 </div>
             </div>

         </div>
     </div>

 </div><?php /**PATH D:\Dream\Laravel Deep Learning\zyco\resources\views/backend/common/my_profile2.blade.php ENDPATH**/ ?>