<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>


<link rel="stylesheet" href="<?php echo e(asset('assets/css/nav_sidebar.css')); ?>" />
<!--<i class="fas fa-ellipsis-vertical"></i> -->

<?php
$user_profileInfo = DB::table('users_personalinfo')->where('user_id',Auth::user()->id)->first();
$site_config = DB::table('site_config')->first();
?>
<aside class="main-sidebar sidebar-dark-secondary  layout-fixed  "
    style="background-color:white;padding-top:45px;padding-bottom:20px">

    <!-- Brand Logo -->
    <!--<a href="<?php echo e(route('driver.dashboard')); ?>" class="brand-link">
		
        <img src="<?php echo e(asset('icons/zyco3.png')); ?>" alt="AdminLTE Logo"
		
		class="brand-image img-circle "  >
		
		<?php if(Auth::guard('admin')->check()): ?>
		
        <span class="brand-text font-weight-light">Zyco Admin Panel</span>
		
		<?php elseif((Auth::user()->user_type) == 'Driver'): ?>
		
		Zyco		
		
		<?php elseif((Auth::user()->user_type) == 'Rider'): ?>
		
		<span class="brand-text font-weight-light">Zyco Rider Panel</span>
		
		<?php endif; ?>
		
	</a>-->
    <div class=" row align-items-center" style="transform: translate(-1px, -8px);">
        <div class=" col-3 ">
            <a href="https://zyco.nl" class="brand-link">

                <!--<img src="<?php echo e(asset('icons/layoutIcons/Group 122.png')); ?>" alt="AdminLTE Logo" class="brand-image" >-->
                <img src="<?php echo e(asset('icons/zyco4.png')); ?>" alt="AdminLTE Docs Logo Small"
                    class="brand-image-xl logo-xs" style="left: 25px;">>
                <img src="<?php echo e(asset('site_pic/'.$site_config->site_logo)); ?>" alt="AdminLTE Docs Logo Large"
                    class="brand-image-xs logo-xl" style="left: 35px;">
            </a>
        </div>
        <div class="col-3">
            <div class="sidenavbar-company-name brand-text">
                <?php echo e($site_config->brand_name); ?>

            </div>
        </div>

        <div class=" col-4 " style="text-align:left"> <a
                class="btn btn-warning text-white btn-sm brand-text  profile_status"
                href="<?php echo e(route('upgrade_profile_packages')); ?>"><span><?php echo e($user_profileInfo->account_classification ?? ''); ?></span></a>
        </div>
    </div>

    <!-- <a class="btn btn-primary btn-xs pushmenu brand-text  " data-widget="pushmenu" href="#" id="my-toggle-button-user"
        onclick="my_toggle_button_user()" role="button"><img
            src="<?php echo e(asset('icons/layoutIcons/Down_Arrow_9_.png')); ?>" /></a> -->
    <div class="sidebar ">
        <a href="#" onclick="divmenu('dashboard')" class="text-center">
            <div class="col-4 ">
                <i class="fa-solid fa-arrow-left text-primary"></i>
            </div>
        </a>
        <!-- Sidebar user panel (optional) -->
        <!-- </a>-->
        <!-- Sidebar Menu -->

        <nav class="mt-2 sidetext sidebak">

            <ul class="nav nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                style="padding-bottom: 12rem;">




                <?php if(Auth::guard('user')): ?>

                <?php echo $__env->make('backend.driver_menus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php endif; ?>

            </ul>

        </nav>









        <!-- /.sidebar-menu -->

    </div>

    <!-- /.sidebar -->

    <div class="footer-sidebar brand-text">


        <div class="footer-profile-detail ">

            <div class="row ">
                <div class="col-4  ">

                    <a href="<?php echo e(route('my_profile')); ?>">
                        <img <?php if(empty($user_profileInfo->profile_picture)): ?>

                        src="<?php echo e(asset('icons/layoutIcons/Group 456.png')); ?>"

                        <?php else: ?>

                        src="<?php echo e(asset('users_personalinfo/'.$user_profileInfo->profile_picture)); ?>"
                        <?php endif; ?> alt="AdminLTE Logo" class=" footer-avatar">
                    </a>
                </div>
                <div class="col-8 profile-detail">
                    <a href="<?php echo e(route('my_profile')); ?>">

                        <?php if(Auth::guard('admin')->check()): ?>

                        <?php echo $__env->make('backend.admin_menus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php elseif(Auth::guard('user')): ?>

                        <small><?php echo e(Auth::user()->first_name); ?> </small> <br />

                        <span> <?php echo e(Auth::user()->user_type); ?></span>
                        <div class="text-left dropdown-profile-status mt-1">
                            <span class="dropdown-profile-status-text">Pro</span>
                        </div>

                        <?php endif; ?> <br>

                    </a>
                    <!-- <div class="col-2 ">
                        
                    </div> -->
                </div>


                <div class="col-12">
                    <a class="btn btn-primary btn-block   upgrade_button" href="<?php echo e(route('upgrade_profile_packages')); ?>">
                        <span class="mt-2 upgrade_button_text">Upgrade</span></a>
                </div>
            </div>

        </div>

    </div>
</aside>

<script type="text/javascript">
function my_toggle_button_user() {
    $('#my-toggle-button-user').find("i").toggleClass('fas fa-angles-left');

    $('#my-toggle-button-user').find("i").toggleClass('fas fa-angles-right');

}

function searchProfile() {

    var searchField = document.getElementById('search').value;
    $(document).ready(function() {



        $.ajax

        ({

            type: "GET",

            url: '<?= route("searchResult") ?>',

            data: {
                value: searchField
            },

            success: function(html)

            {

                alert(html);

            }

        });



    });

}
var path = "<?php echo e(route('autocomplete')); ?>";

$('input.typeahead').typeahead({

    source: function(query, process) {

        return $.get(path, {
            query: query
        }, function(data) {

            console.log(data);

            return process(data);

        });

    }

}).on('typeahead:selected', function(event, selection) {



    // the second argument has the info you want

    alert(selection.value);



    // clearing the selection requires a typeahead method

    $(this).typeahead('setQuery', '');

});
</script><?php /**PATH D:\Dream\Laravel Deep Learning\zyco\resources\views/backend/nav_sidebar.blade.php ENDPATH**/ ?>