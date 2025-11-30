<!--<a class="brand-link" href="{{route('driver.dashboard')}}">

<img src="{{asset('icons/zyco4.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"> -->



<link rel="stylesheet" href="{{asset('assets/css/navbar.css')}}" />

<?php
$dispatch_menu = "class='nav-item d-none d-sm-inline-block'";
$contact_menu = "class='nav-item d-none d-sm-inline-block'";
$dashboard_menu = "class='nav-item d-none d-sm-inline-block'";
if ($main_menu) {
    if ($main_menu == 'dispatch') :
        $dispatch_menu = "class='nav-item d-none d-sm-inline-block active'";
        $contact_menu = "class='nav-item d-none d-sm-inline-block'";
        $dashboard_menu = "class='nav-item d-none d-sm-inline-block'";
    elseif ($main_menu == 'dashboard') :
        $dispatch_menu = "class='nav-item d-none d-sm-inline-block'";
        $contact_menu = "class='nav-item d-none d-sm-inline-block'";
        $dashboard_menu = "class='nav-item d-none d-sm-inline-block active'";
    elseif ($main_menu == 'contact') :
        $dashboard_menu = "class='nav-item d-none d-sm-inline-block'";
        $dispatch_menu = "class='nav-item d-none d-sm-inline-block'";
        $contact_menu = "class='nav-item d-none d-sm-inline-block active'";
    endif;
}

?>

@php
$user_profileInfo = DB::table('users_personalinfo')->where('user_id',Auth::user()->id)->first();

@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light topbak toptext">
    <!-- <a href="index3.html" class="navbar-brand brand-link">

		<img src="{{asset('icons/zyco4.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"

		style="opacity: .8">

		<span class="brand-text font-weight-light">Zyco</span>

	</a> -->

    <a class="btn btn-primary btn-lg pushmenumobile brand-text" data-widget="pushmenu" href="#" role="button"
        id="my-toggle-button"><i class="fas fa-angles-left"></i></a>


    <!-- Left navbar links -->
    <div id="topnav">

        <ul class="nav navbar-nav  ml-5">

            @if(Auth::user())
            <li <?php echo $dashboard_menu ?>>



                <a href="#" onclick="divmenu('dashboard')" class="nav-link">

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

            <li <?php $dispatch_menu ?>>



                <a href="#" onclick="divmenu('dispatch')" class="nav-link">

                    <div class="row" style="">

                        <div class="col-4 icondiv ">
                            <div class="icon centered"></div>
                        </div>

                        <div class="col-8" style="padding-top:.18rem"><span>Dispatch</span><br /><small>120+</small>
                        </div>

                    </div>

                </a>

            </li>
            <li <?php echo $contact_menu ?>> <a href="#" onclick="divmenu('contact')" class="nav-link">

                    <div class="row" style="">

                        <div class="col-4 icondiv ">
                            <div class="icon centered"></div>
                        </div>

                        <div class="col-8" style="padding-top:.18rem"><span>Contact</span><br /><small>120+</small>
                        </div>

                    </div>

                </a>

            </li>

            <!--	<li class="nav-item d-none d-sm-inline-block">

				<a href="{{ route('dispatch_create')}}" class="nav-link">

				<div class="  pr-3 pl-2 pt-2 pb-2 m-2 row" style="border-radius:50px">

						<div class="col-md-4"><i class="fa-solid fa-car text-white primary-color" style=" border-radius: 50%;border: 1px solid white;padding: 10px;"></i></div>

				<div class="col-md-8"><span>Booking</span><br/><small>120+</small></div>

				</div>	

				</a>

			</li>



			 <li class="nav-item d-none d-sm-inline-block">

				<a href="{{ route('mygroup')}}" class="nav-link">

					<div class="  pr-3 pl-2 pt-2 pb-2 m-2 row" style="border-radius:50px">

						<div class="col-md-4"><i class="fa-solid fa-car text-white primary-color" style=" border-radius: 50%;border: 1px solid white;padding: 10px;"></i></div>

				<div class="col-md-8"><span>Groups</span><br/><small>120+</small></div>

				</div>	

				</a>

			</li>

			<li class="nav-item">

				<a href="#" class="nav-link">

					<p>My Rides

					</p>

				</a>
				
			</li>

			  

			 <li class="nav-item">

				<a href="{{ route('mygroup')}}" class="nav-link">

					<p>

						Customers

					</p>

				</a>

			</li> -->



        </ul>
    </div>


    <!-- <form action="{{route('searchResult')}}" method="POST">

			@csrf

			<div class="form-inline">

				<div class="input-group m-3">

					

					<input type="text" class="typeahead form-control  " placeholder="Search" id="search" name="search" aria-label="Recipient's username" aria-describedby="basic-addon2">

					<div class="input-group-append">

						<button class="btn btn-default"  type="submit">	<i class="fas fa-search fa-fw"></i></button>

					</div>

				</div>

			</div>

		</form> -->

    <!-- SEARCH FORM -->



    @endif

    <!-- Right navbar links -->



    <div class="topmenuleft ml-auto">

        <ul class="nav navbar-nav ">

            <!-- Messages Dropdown Menu -->








            <!-- Status Dropdown Menu -->

            <li class="nav-item dropdown">

                <a class="nav-link  " data-toggle="dropdown" href="#">

                    <i class="far fa-user-circle  " style="font-size: 2.083vw;"></i>

                    <!-- @if(Auth::user()->driver_activity_status == 1) -->

                    <span class="p-1 bg-success navbar-badge border border-light rounded-circle"></span>



                    @elseif(Auth::user()->driver_activity_status == 2)

                    <span class="p-1 bg-danger navbar-badge border border-light rounded-circle"></span>



                    @elseif(Auth::user()->driver_activity_status == 3)

                    <span class="p-1 bg-warning navbar-badge border border-light rounded-circle"></span>



                    @else

                    <span class="p-1 bg-secondary navbar-badge border border-light rounded-circle"></span>



                    @endif

                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                    <button onclick="updateSingleData({{Auth::user()->id}},'users','driver_activity_status','1')"
                        class="dropdown-item">@if(Auth::user()->driver_activity_status == 1)<i class="fas fa-check"></i>

                        <span class="float-right text-muted text-sm"><span
                                class="p-1 bg-success border border-light"></span></span>

                        @endif Online</button>

                    <div class="dropdown-divider"></div>

                    <button onclick="updateSingleData({{Auth::user()->id}},'users','driver_activity_status','2')"
                        class="dropdown-item">@if(Auth::user()->driver_activity_status == 2)<i class="fas fa-check"></i>

                        <span class="float-right text-muted text-sm"><span
                                class="p-1 bg-danger border border-light "></span></span>

                        @endif Offline</button>

                    <div class="dropdown-divider"></div>

                    <button onclick="updateSingleData({{Auth::user()->id}},'users','driver_activity_status','3')"
                        class="dropdown-item">@if(Auth::user()->driver_activity_status == 3)<i class="fas fa-check"></i>

                        <span class="float-right text-muted text-sm"><span
                                class="p-1 bg-warning  border border-light "></span></span>

                        @endif Busy</button>

                    <div class="dropdown-divider"></div>

                    <button onclick="updateSingleData({{Auth::user()->id}},'users','driver_activity_status','0')"
                        class="dropdown-item">@if(Auth::user()->driver_activity_status == 0)<i
                            class="fas fa-check"></i><span class="float-right text-muted text-sm"><span
                                class="p-1 bg-secondary border border-light "></span></span>

                        @endif Unavailable



                    </button>

                    <div class="dropdown-divider"></div>

                </div>

            </li>


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
            <?php
            $groupNotify = DB::table('users_group_members')->where('member_id', '=', Auth::user()->id)->where('status', '=', '0')->get();
            $gCount = count($groupNotify);

            $open_balance = DB::table('user_wallet')->where('user_id', Auth::user()->id)->first();
            $credit = DB::table('user_wallet_transection')->where([['user_id', '=', Auth::user()->id], ['transection_type', 'credit']])->sum('amount');
            $debit = DB::table('user_wallet_transection')->where([['user_id', '=', Auth::user()->id], ['transection_type', 'debit']])->sum('amount');
            $balance = (floatval($open_balance) + floatval($credit)) - floatval($debit);
            ?>
            <li class="nav-item dropdown">

                <a class="nav-link " data-toggle="dropdown" href="#">
                    <!--	src="https://app.zyco.nl/public/icons/layoutIcons/active.png')}}"-->
                    <img src="https://app.zyco.nl/public/icons/layoutIcons/Notification.png')}}" alt=""
                        class="topnavothericon" />
                    <div class="notification_number"><?php if ($gCount >= 1) : echo $gCount;
                                                        endif; ?></div>

                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown-header"><?php if ($gCount >= 1) : echo $gCount;
                                                    endif; ?> Notifications</div>

                    <!-- <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a> -->
                    <?php if (count($groupNotify)) : foreach ($groupNotify as $gData) :
                            $member_id = $gData->member_id;
                            $group_id = $gData->group_id;
                            $notify_time = date("Y-m-d", strtotime($gData->created_at));
                            $current_date = date("Y-m-d", time());


                            $date1 = date_create($notify_time);
                            $date2 = date_create($current_date);
                            $diff = date_diff($date1, $date2);
                            //$months = $diff->format("%m months");
                            //$years = $diff->format("%y years");
                            $days = $diff->format("%d days");

                            $result = DB::table('users_group')
                                ->select('users_group.*', 'users.first_name', 'users.last_name')
                                ->join('users', 'users.id', '=', 'users_group.group_owner')
                                ->where(['users_group.id' => $group_id])
                                ->get();
                            if (count($result)) : foreach ($result as $data) :
                                    $groupId = $data->id;
                                    $group_name = $data->group_name;
                                    $group_logo = $data->group_logo;
                                    $group_description = $data->group_description;
                                    $first_name = $data->first_name;
                                    $last_name = $data->last_name;
                                endforeach;
                            else :
                                $groupId = "";
                                $group_name = "";
                                $group_logo = "";
                                $group_description = "";
                                $first_name = "";
                                $last_name = "";
                            endif;
                    ?>
                    <div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
                        <div class="dropdown-list-image mr-3">
                            <?php if (!empty($group_logo)) : ?>
                            <img class="rounded-circle" src="{{ asset('group_photo/'.$group_logo) }}"
                                alt="Group Logo">
                            <?php else : ?>
                            <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar3.png')}}"
                                alt="" />
                            <?php endif; ?>
                        </div>
                        <div class="font-weight-bold mr-3">
                            <p><?php echo $group_name; ?></p>
                            <div class="small">
                                <?php echo $first_name . " " . $last_name . " send you a group request"; ?></div>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"
                                        onclick="updateSingleData('<?php echo $gData->id; ?>','users_group_members','status','1')"><i
                                            class="mdi mdi-delete"></i> Confirm</button>
                                    <button class="dropdown-item" type="button"
                                        onclick="updateSingleData('<?php echo $gData->id; ?>','users_group_members','status','2')"><i
                                            class="mdi mdi-close"></i> Reject</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1"><?php if ((int)$days > 1) : echo $days;
                                                                            else : echo date("H:i A", strtotime($gData->created_at));
                                                                            endif; ?></div>
                        </span>
                    </div>
                    <?php endforeach;
                    endif; ?>
                    <!--    <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>-->
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
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


                    <a href="{{ route('upgrade_profile_packages') }}" class="dropdown-item">
                        My Subscription
                    </a>
                    <a href="{{ route('my_wallet') }}" class="dropdown-item">
                        Wallet
                        <span class="float-right text-sm">@if(!empty(Auth::user()->currency_code))
                            {{Auth::user()->currency_code}} @endif {{number_format($balance,2)}}</span>
                    </a>

                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"> Change
                        Theme</a>

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