<?php
$dashboad_style = "style='display:none'";
$contact_style = "style='display:none'";
$dispatch_style = "style='display:none'";
$profile_style = "style='display:none'";
$settings_style = "style='display:none'";
$groups_style = "style='display:none'";
if ($main_menu == 'dispatch') :
    $dashboad_style = "style='display:none'";
    $contact_style = "style='display:none'";
    $profile_style = "style='display:none'";
    $settings_style = "style='display:none'";
    $groups_style = "style='display:none'";
    $dispatch_style = "";
elseif ($main_menu == 'dashboard') :

    $contact_style = "style='display:none'";
    $dispatch_style = "style='display:none'";
    $profile_style = "style='display:none'";
    $settings_style = "style='display:none'";
    $groups_style = "style='display:none'";
    $dashboad_style = "";
elseif ($main_menu == 'contact') :
    $dashboad_style = "style='display:none'";
    $dispatch_style = "style='display:none'";
    $profile_style = "style='display:none'";
    $settings_style = "style='display:none'";
    $groups_style = "style='display:none'";
    $contact_style = '';
elseif ($main_menu == 'profile') :
    $dashboad_style = "style='display:none'";
    $dispatch_style = "style='display:none'";
    $profile_style = "";
    $settings_style = "style='display:none'";
    $groups_style = "style='display:none'";
    $contact_style = "style='display:none'";
elseif ($main_menu == 'settings') :
    $dashboad_style = "style='display:none'";
    $dispatch_style = "style='display:none'";
    $profile_style = "style='display:none'";
    $settings_style = "";
    $groups_style = "style='display:none'";
    $contact_style = "style='display:none'";
elseif ($main_menu == 'groups') :
    $dashboad_style = "style='display:none'";
    $dispatch_style = "style='display:none'";
    $contact_style = "style='display:none'";
    $profile_style = "style='display:none'";
    $settings_style = "style='display:none'";
    $groups_style = "";
endif;
?>
<script type="text/javascript" src="https://unpkg.com/external-svg-loader@latest/svg-loader.min.js" async></script>

<div id="dashboard" class="dashboard" <?php echo $dashboad_style ?>>
    <!-- <li class="nav-item">
        <a href="{{ route('driver.dashboard')}}" onClick="divmenu('dashboard')" class="nav-link active">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/4-rounded-squares.svg" />
                    <p>General</p>
                </div>
                <div class="col-2 text-center">
 
                </div>
            </div>
        </a>
    </li> -->
    <li class="nav-item">
        <a href="#4" onClick="divmenu('profile')" class="nav-link <?php if ($main_menu == 'profile') : echo 'active';
                                                                    endif; ?>">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/user (1).svg" />
                    <p>Profile</p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>
    </li>
    <li class="nav-item">
        <a href="#1" onClick="divmenu('dispatch')" class="nav-link <?php if ($main_menu == 'dispatch') : echo 'active';
                                                                    endif; ?>">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/delivery.svg" />
                    <p>Dispatch</p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>
    </li>
    <li class="nav-item">

        <a href="#2" onClick="divmenu('contact')" class="nav-link <?php if ($main_menu == 'contact') : echo 'active';
                                                                    endif; ?>">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/chat-bubbles-with-ellipsis.svg" />
                    <p>Contact</p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>

    </li>
    <li class="nav-item">

        <a href="#2" onClick="divmenu('groups')" class="nav-link <?php if ($main_menu == 'groups') : echo 'active';
                                                                    endif; ?>">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/chat-bubbles-with-ellipsis.svg" />
                    <p>Groups</p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>

    </li>
    <!-- <li class="nav-item">

        <a href="#3" onClick="divmenu('dashboard')" class="nav-link">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/management.svg" />
                    <p>CRM</p>
                </div>
                <div class="col-2 text-center">
                 
                </div>
            </div>
        </a>

    </li> -->

    <li class="nav-item">

        <a href="#5" onClick="divmenu('vehicle')" class="nav-link <?php if ($main_menu == 'vehicle') : echo 'active';
                                                                    endif; ?>">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/car.svg" />
                    <p>Vehicle</p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>

    </li>
    <!-- <li class="nav-item">

        <a href="#6" onClick="divmenu('dashboard')" class="nav-link">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/admin.svg" />
                    <p>Administration</p>
                </div>
                <div class="col-2 text-center">
 
                </div>
            </div>
        </a>
 
    </li> -->
    <!-- <li class="nav-item">

        <a href="#7" onClick="divmenu('dashboard')" class="nav-link">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/level-up.svg" />
                    <p>Upgrade</p>
                </div>
                <div class="col-2 text-center">
 
                </div>
            </div>
        </a>

    </li> -->

    <li class="nav-item">

        <a href="#7" onClick="divmenu('settings')" class="nav-link <?php if ($main_menu == 'settings') : echo 'active';
                                                                    endif; ?>">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/settings.svg" />
                    <p>Settings</p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>
    </li>

</div>

<div id="contact" class="contact" <?php echo $contact_style; ?>>
    <li class="nav-item">
        <a href="#11" onClick="divmenu('contact')" class="nav-link active">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <svg data-src="https://app.zyco.nl/public/icons/layoutIcons/user.svg" class="nav-icon" fill="red"></svg>
                    <!--	<img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/user.svg"/>-->
                    <p>Chat
                    </p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>
    </li>
</div>
<div id="groups" class="groups" <?php echo $groups_style; ?>>
    <li class="nav-item">
        <a href="{{ route('group')}}" class="nav-link">

            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/people.svg" />
                    <p>My Groups
                    </p>
                </div>
                <div class="col-2 text-center">

                    <!--img class="right" /-->
                </div>
            </div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('group_have_joined')}}" class="nav-link">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/team.svg" />
                    <p>Other Groups
                    </p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>
    </li>
</div>
<div id="profile" class="profile" <?php echo $profile_style; ?>>
    <li class="nav-item">

        <a href="{{ route('my_profile')}}" class="nav-link">

            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/user (1).svg" />
                    <p>My Profile
                    </p>
                </div>
                <div class="col-2 text-center">
                    <!--img class="right" /-->
                </div>
            </div>
        </a>
    </li>
</div>
<div id="settings" class="settings" <?php echo $settings_style; ?>>
    <li class="nav-item">

        <a href="{{ route('profileUpdate')}}" class="nav-link">

            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/user (1).svg" />
                    <p>Profile
                    </p>
                </div>
                <div class="col-2 text-center">
                    <!--img class="right" /-->
                </div>
            </div>
        </a>
    </li>
    <li class="nav-item">

        <a href="{{ route('vehicle_list')}}" class="nav-link">

            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/car.svg" />
                    <p>Vehicle
                    </p>
                </div>
                <div class="col-2 text-center">
                    <!--img class="right" /-->
                </div>
            </div>
        </a>
    </li>
</div>
<div id="dispatch" class="dispatch" <?php echo $dispatch_style; ?>>
    <li class="nav-item ">

        <a href="{{ route('dispatch_create')}}" class="nav-link ">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/delivery.svg" />
                    <p>Dispatch
                    </p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('user_list')}}" onClick="divmenu('dispatch')" class="nav-link">
            <div class="row">
                <div class="col-2 text-center">
                    <div class="left"> </div>
                </div>
                <div class="col center-content">
                    <svg data-src="https://app.zyco.nl/public/icons/layoutIcons/user.svg" class="nav-icon" fill="red"></svg>


                    <!--	<img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/user.svg"/>-->
                    <p>Drivers List
                    </p>
                </div>
                <div class="col-2 text-center">
                    <!--	<div class="right"> </div> -->
                </div>
            </div>
        </a>
    </li>



    <!-- <li class="nav-item">
                <a href="{{ route('auto_assign_rule')}}" class="nav-link">
                    <div class="row">
                        <div class="col-2 text-center">
                            <div class="left"> </div>
                        </div>
                        <div class="col center-content">
                            <img class="nav-icon" src="https://app.zyco.nl/public/icons/layoutIcons/check.svg" />
                            <p>Auto Assign
                            </p>
                        </div>
                        <div class="col-2 text-center">
                          
                        </div>
                    </div>
                </a>

            </li> -->



    <script language="javascript">
        function divmenu(val) {

            if (val == "dashboard") {

                $("#dashboard").show();
                $("#dispatch").hide();
                $("#contact").hide();
                $("#profile").hide();
                $("#settings").hide();
                $("#groups").hide();

            } else if (val == "dispatch") {

                $("#dashboard").hide();
                $("#dispatch").show();
                $("#contact").hide();
                $("#profile").hide();
                $("#settings").hide();
                $("#groups").hide();

            } else if (val == "contact") {

                $("#dashboard").hide();
                $("#dispatch").hide();
                $("#contact").show();
                $("#profile").hide();
                $("#settings").hide();
                $("#groups").hide();
            } else if (val == "profile") {

                $("#dashboard").hide();
                $("#dispatch").hide();
                $("#contact").hide();
                $("#profile").show();
                $("#settings").hide();
                $("#groups").hide();
            } else if (val == "groups") {

                $("#dashboard").hide();
                $("#dispatch").hide();
                $("#contact").hide();
                $("#profile").hide();
                $("#settings").hide();
                $("#groups").show();
            } else if (val == "settings") {
                $("#dashboard").hide();
                $("#dispatch").hide();
                $("#contact").hide();
                $("#profile").hide();
                $("#settings").show();
                $("#groups").hide();
            } else {
                $("#dashboard").show();
                $("#dispatch").hide();
                $("#contact").hide();
                $("#profile").hide();
                $("#settings").hide();
                $("#groups").hide();

            }
        }
    </script>