<?php
$general_style = "style='display:none'";
$admin_style = "style='display:none'";
$support_style = "style='display:none'";
$profile_style = "style='display:none'";
$settings_style = "style='display:none'";
$groups_style = "style='display:none'";
if ($main_menu == 'support') :
    $general_style = "style='display:none'";
    $admin_style = "style='display:none'";
    $profile_style = "style='display:none'";
    $settings_style = "style='display:none'";
    $groups_style = "style='display:none'";
    $support_style = "";
elseif ($main_menu == 'general') :

    $admin_style = "style='display:none'";
    $support_style = "style='display:none'";
    $profile_style = "style='display:none'";
    $settings_style = "style='display:none'";
    $groups_style = "style='display:none'";
    $general_style = "";
elseif ($main_menu == 'admin') :
    $general_style = "style='display:none'";
    $support_style = "style='display:none'";
    $profile_style = "style='display:none'";
    $settings_style = "style='display:none'";
    $groups_style = "style='display:none'";
    $admin_style = '';

endif;
?>
<script type="text/javascript" src="https://unpkg.com/external-svg-loader@latest/svg-loader.min.js" async></script>
<div id="general" class="general" <?php echo $general_style ?>>


    <li class="nav-item">
        <a href="#4" onClick="divmenu('admin')" class="nav-link <?php if ($main_menu == 'profile') : echo 'active';
                                                                endif; ?>">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/user (1).svg" />
                    <p>Admin</p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>
    </li>
    <li class="nav-item">
        <a href="#4" onClick="divmenu('Support')" class="nav-link <?php if ($main_menu == 'profile') : echo 'active';
                                                                    endif; ?>">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/user (1).svg" />
                    <p>Support</p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>
    </li>
</div>
























<div id="admin" class="admin" <?php echo $admin_style; ?>>

    <li class="nav-item">

        <a href="{{ route('dashboard')}}" class="nav-link">

            <div class="row">
                <div class="col-1 text-center">
                    <div class="left"></div>
                </div>
                <div class="col center-content">


                    <img class="nav-icon" src="{{asset('icons/layoutIcons/4-rounded-squares.svg')}}" />

                    <p>

                        {{trans('messages.admin_dashboard.dashboard')}}

                    </p>
                </div>

            </div>

        </a>

    </li>

    {{--<li class="nav-item">
	
    <a href="{{ route('admin_profile')}}" class="nav-link">
    <div class="row">
        <div class="col-1 text-center">
            <div class="left"> </div>
        </div>
        <div class="col center-content">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                My Profile
            </p>
        </div>

    </div>

    </a>

    </li> --}}

    <li class="nav-item">

        <a href="{{ route('account_upgradation_application')}}" class="nav-link">
            <div class="row">
                <div class="col-1 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">


                    <img class="nav-icon" src="{{asset('icons/layoutIcons/forward.svg')}}" />

                    <p>

                        Profile Upgradation

                    </p>
                </div>

            </div>

        </a>

    </li>

    <li class="nav-item">
        <a href="{{ route('all_vehicle_list')}}" class="nav-link">
            <div class="row">
                <div class="col-1 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="{{asset('icons/layoutIcons/car.svg')}}" />
                    <p>
                        Vehicles
                    </p>
                </div>
            </div>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('account_classification_package')}}" class="nav-link">
            <div class="row">
                <div class="col-1 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="{{asset('icons/layoutIcons/gift.svg')}}" />
                    <p>
                        Classification Package
                    </p>
                </div>
            </div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('vehicle_setup')}}" class="nav-link">

            <div class="row">
                <div class="col-1 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="{{asset('icons/layoutIcons/information.svg')}}" />

                    <p>

                    <p> {{trans('messages.admin_dashboard.vehicles_management')}}</p>

                    </p>
                </div>

            </div>
        </a>
    </li>
    <li class="nav-item">
        <a href="#admin_management" class="nav-link">
            <div class="row">
                <div class="col-1 text-center">

                </div>
                <div class="col center-content">

                    <img class="nav-icon" src="{{asset('icons/layoutIcons/admin.svg')}}" />
                    <p>
                        {{trans('messages.admin_dashboard.admin_management')}}
                    </p>
                </div>
                <div class="col-2 text-center">
                    <div class="right"> </div>
                </div>
            </div>
        </a>

        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin_list')}}" class="nav-link">

                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/shortlist.svg')}}" />
                            <p>
                            <p> {{trans('messages.admin_dashboard.admin_users')}}</p>
                            </p>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('siteConfig')}}" class="nav-link">
                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />
                            <p>
                            <p>Site Setup</p>
                            </p>
                        </div>

                    </div>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">

        <a href="#form_setup" class="nav-link">
            <div class="row">
                <div class="col-1 text-center">

                </div>
                <div class="col center-content">

                    <img class="nav-icon" src="{{asset('icons/layoutIcons/web-page.svg')}}" />
                    <p>
                        Form Setup
                    </p>
                </div>
                <div class="col-2 text-center">
                    <div class="right"> </div>
                </div>
            </div>
        </a>

        <ul class="nav nav-treeview">



            <li class="nav-item">
                <a href="{{ route('vehicleConfig')}}" class="nav-link">


                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />

                            <p>

                            <p>Vehicle Form</p>


                            </p>
                        </div>

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('companyConfig')}}" class="nav-link">


                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />

                            <p>

                            <p>Company Form</p>


                            </p>
                        </div>

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vatConfig')}}" class="nav-link">


                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />

                            <p>

                            <p>Vat Form</p>


                            </p>
                        </div>

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('groupConfig')}}" class="nav-link">


                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />

                            <p>

                            <p>Group Form</p>


                            </p>
                        </div>

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('postalConfig')}}" class="nav-link">



                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />

                            <p>

                            <p>Postal Form</p>


                            </p>
                        </div>

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('documentConfig')}}" class="nav-link">



                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />

                            <p>

                            <p>Document Form</p>


                            </p>
                        </div>

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('personalConfig')}}" class="nav-link">


                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />

                            <p>

                            <p>Personal Form</p>


                            </p>
                        </div>

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('basicConfig')}}" class="nav-link">


                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />

                            <p>

                            <p>Basic Form</p>


                            </p>
                        </div>

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bankConfig')}}" class="nav-link">



                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />

                            <p>


                            <p>Bank Form</p>

                            </p>
                        </div>

                    </div>
                </a>
            </li>

        </ul>

    </li>

    <li class="nav-item">

        <a href="#Email" class="nav-link">
            <div class="row">
                <div class="col-1 text-center">

                </div>
                <div class="col center-content">

                    <img class="nav-icon" src="{{asset('icons/layoutIcons/web-page.svg')}}" />
                    <p>
                        Template Manager
                    </p>
                </div>
                <div class="col-2 text-center">
                    <div class="right"> </div>
                </div>
            </div>
        </a>

        <ul class="nav nav-treeview">


            <li class="nav-item">
                <a href="{{ route('template-email')}}" class="nav-link">

                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />
                            <p>Email Template</p>
                        </div>
                    </div>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('template-sms')}}" class="nav-link">

                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="{{asset('icons/layoutIcons/survey.svg')}}" />
                            <p>SMS Template</p>
                        </div>
                    </div>
                </a>
            </li>

        </ul>

    </li>



    <li class="nav-item">

        <a href="{{ route('country')}}" class="nav-link">
            <div class="row">
                <div class="col-1 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="{{asset('icons/layoutIcons/coronavirus.svg')}}" />

                    <p>

                        {{trans('messages.admin_dashboard.manage_country')}}

                    </p>
                </div>

            </div>

        </a>

    </li>








    <li class="nav-item">

        <a href="{{ route('currency')}}" class="nav-link">
            <div class="row">
                <div class="col-1 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="{{asset('icons/layoutIcons/currency.svg')}}" />

                    <p>

                        {{trans('messages.admin_dashboard.manage_currency')}}

                    </p>
                </div>

            </div>
        </a>

    </li>
    <li class="nav-item">

        <a href="{{ route('fees')}}" class="nav-link">
            <div class="row">
                <div class="col-1 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="{{asset('icons/layoutIcons/currency.svg')}}" />

                    <p>

                        Fees

                    </p>
                </div>

            </div>
        </a>

    </li>

    <li class="nav-item">

        <a href="{{ route('language')}}" class="nav-link">
            <div class="row">
                <div class="col-1 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="{{asset('icons/layoutIcons/web-coding.svg')}}" />

                    <p>

                        {{trans('messages.admin_dashboard.manage_language')}}

                    </p>
                </div>

            </div>

        </a>

    </li>
</div>











<script language="javascript">
function divmenu(val) {

    if (val == "general") {

        $("#general").show();
        $("#admin").hide();
        $("#support").hide();
        $("#profile").hide();
        $("#settings").hide();
        $("#groups").hide();

    } else if (val == "admin") {

        $("#general").hide();
        $("#admin").show();
        $("#support").hide();
        $("#profile").hide();
        $("#settings").hide();
        $("#groups").hide();

    } else if (val == "support") {

        $("#general").hide();
        $("#admin").hide();
        $("#support").show();
        $("#profile").hide();
        $("#settings").hide();
        $("#groups").hide();
    } else if (val == "profile") {

        $("#general").hide();
        $("#admin").hide();
        $("#support").hide();
        $("#profile").show();
        $("#settings").hide();
        $("#groups").hide();
    } else if (val == "groups") {

        $("#general").hide();
        $("#admin").hide();
        $("#support").hide();
        $("#profile").hide();
        $("#settings").hide();
        $("#groups").show();
    } else if (val == "settings") {
        $("#general").hide();
        $("#admin").hide();
        $("#support").hide();
        $("#profile").hide();
        $("#settings").show();
        $("#groups").hide();
    } else {
        $("#general").show();
        $("#admin").hide();
        $("#support").hide();
        $("#profile").hide();
        $("#settings").hide();
        $("#groups").hide();

    }
}
</script>