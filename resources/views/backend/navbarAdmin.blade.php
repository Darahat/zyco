<!--<a class="brand-link" href="{{route('driver.dashboard')}}">

<img src="{{asset('icons/zyco4.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"> -->
<link rel="stylesheet" href="{{asset('assets/css/navbar.css')}}" />

<nav class="main-header navbar navbar-expand navbar-white navbar-light topbak toptext">
    <?php
    $general_menu = "class='nav-item d-none d-sm-inline-block'";
    $admin_menu = "class='nav-item d-none d-sm-inline-block'";
    $support_menu = "class='nav-item d-none d-sm-inline-block'";
    if ($main_menu) {
        if ($main_menu == 'admin') :
            $admin_menu = "class='nav-item d-none d-sm-inline-block active'";
            $support_menu = "class='nav-item d-none d-sm-inline-block'";
            $general_menu = "class='nav-item d-none d-sm-inline-block'";
        elseif ($main_menu == 'general') :
            $admin_menu = "class='nav-item d-none d-sm-inline-block'";
            $support_menu = "class='nav-item d-none d-sm-inline-block'";
            $general_menu = "class='nav-item d-none d-sm-inline-block active'";
        elseif ($main_menu == 'support') :
            $general_menu = "class='nav-item d-none d-sm-inline-block'";
            $admin_menu = "class='nav-item d-none d-sm-inline-block'";
            $support_menu = "class='nav-item d-none d-sm-inline-block active'";
        endif;
    }
    ?>
    <!-- <a href="index3.html" class="navbar-brand brand-link">

		<img src="{{asset('icons/zyco4.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"

		style="opacity: .8">

		<span class="brand-text font-weight-light">Zyco</span>

	</a> -->





    <a class="btn btn-primary btn-sm pushmenumobile brand-text m-5" data-widget="pushmenu" href="#" role="button"
        id="my-toggle-button"><i class="fas fa-angles-left"></i></a>


    <!-- Left navbar links -->
    <div id="topnav">




        <ul class="nav navbar-nav mr-4 ml-5">
            <li <?php echo $general_menu ?>>
                <a href="#" onclick="divmenu('general')" class="nav-link active">

                    <div class="row" style="">

                        <div class="col-4 icondiv ">
                            <div class="icon centered"></div>
                        </div>

                        <div class="col-8 textdiv" style="padding-top:.18rem">
                            <span>General</span><br /><small>120+</small>
                        </div>

                    </div>

                </a>

            </li>

            <li <?php echo $admin_menu ?>>



                <a href="#" onClick="divmenu('admin')" class="nav-link">

                    <div class="row" style="">

                        <div class="col-4 icondiv ">
                            <div class="icon centered"></div>
                        </div>

                        <div class="col-8" style="padding-top:.18rem">
                            <span>Admin</span><br /><small>120+</small>
                        </div>

                    </div>

                </a>

            </li>

            <li <?php echo $support_menu ?>>



                <a href="#" onClick="divmenu('support')" class="nav-link">

                    <div class="row" style="">

                        <div class="col-4 icondiv ">
                            <div class="icon centered"></div>
                        </div>

                        <div class="col-8" style="padding-top:.18rem"><span>Support</span><br /><small>120+</small>
                        </div>

                    </div>

                </a>

            </li>
        </ul>
    </div>
    <!-- Right navbar links -->
    <div class="topmenuleft ml-auto">

        <ul class="nav navbar-nav ">

            <!-- Messages Dropdown Menu -->
            <!-- Status Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link " data-toggle="dropdown" href="#">
                    <img src="https://app.zyco.nl/public/icons/layoutIcons/chat.png')}}" alt="" class="topnavothericon" />

                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Messages</span>

                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>

                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>

                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link " data-toggle="dropdown" href="#">
                    <!--	src="https://app.zyco.nl/public/icons/layoutIcons/active.png')}}"-->
                    <img src="https://app.zyco.nl/public/icons/layoutIcons/Notification.png')}}" alt=""
                        class="topnavothericon" />
                    <div class="notification_number">0</div>

                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Messages</span>

                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>

                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>

                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            </li>
            <li class="nav-item dropdown  ">

                <a class="nav-link " data-toggle="dropdown" href="#">
                    <img class=" menu-profile-avatar" id="menu-avatar" alt="Avatar"
                        @if(empty($user_profileInfo->profile_picture))

                    src="{{ asset('icons/layoutIcons/Group 456.png') }}"

                    @else

                    src="{{ asset('users_personalinfo/'.$user_profileInfo->profile_picture) }}"
                    @endif>
                    <img src="https://app.zyco.nl/public/icons/layoutIcons/caret-down.png')}}"
                        class="topavatarmiddleicon" />

                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right  dropdown-profile">

                    <div class="dropdown-profile-div row">

                        <div class="col-3">
                            <img class=" dropdown-profile-avatar" id="dropdown-avatar" alt="Avatar"
                                @if(empty($user_profileInfo->profile_picture))

                            src="{{ asset('icons/layoutIcons/Group 456.png') }}"

                            @else

                            src="{{ asset('users_personalinfo/'.$user_profileInfo->profile_picture) }}"
                            @endif>
                        </div>
                        <div class="col-6 ">
                            @if(Auth::guard('admin')->check())
                            <small>{{Auth::guard('admin')->user()->username}} </small> <br>
                            @elseif(Auth::user())

                            <small>{{Auth::user()->first_name}} {{Auth::user()->last_name}} </small> <br>
                            <span> {{Auth::user()->user_type}}</span>
                            @endif
                        </div>
                        <div class="col-2 ">

                            <div class="text-left dropdown-profile-status">
                                <p class="dropdown-profile-status-text">Pro</p>
                            </div>
                        </div>


                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('profileUpdate') }}" class="dropdown-item">
                        My Profile
                    </a>
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"> Change
                        Theme</a>

                    <!--<a href="{{ route('upgrade_profile_packages') }}" class="dropdown-item">
					My Subscription
				</a>
				<a href="{{ route('my_wallet') }}" class="dropdown-item">
					Wallet
					<span class="float-right">0.00</span>
				</a> -->



                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item " data-slide="true" href="{{ route('signout') }}" role="button">Sign out <i
                            class="fas fa-sign-out-alt"></i></a>
                    <br />




                </div>

            </li>

        </ul>
    </div>
</nav>





<script>
var url = window.location;



// for sidebar menu entirely but not cover treeview

$('.main-header a').filter(function() {

    return this.href == url;

}).addClass('active');





// for sidebar menu entirely but not cover treeview

$('ul.nav-sidebar a').filter(function() {

    return this.href == url;

}).addClass('active');



// for treeview

$('ul.nav-treeview a').filter(function() {

    return this.href == url;

}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');


$('#topnav .navbar-nav a').on('click', function() {
    $('#topnav .navbar-nav').find('li.active').removeClass('active');
    $(this).parent('li').addClass('active');
});
</script>