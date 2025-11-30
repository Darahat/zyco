@php

$site_config = DB::table('site_config')->first();
@endphp
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>


<link rel="stylesheet" href="{{asset('assets/css/nav_sidebar.css')}}" />
<!--<i class="fas fa-ellipsis-vertical"></i> -->
<aside class="main-sidebar sidebar-dark-secondary  layout-fixed  "
    style="background-color:white;padding-top:45px;padding-bottom:20px">
    <div class=" row align-items-center" style="transform: translate(-1px, -8px);">
        <div class=" col-3 ">

            <a href="https://zyco.nl" class="brand-link">

                <!--<img src="{{asset('icons/layoutIcons/Group 122.png')}}" alt="AdminLTE Logo" class="brand-image" >-->
                <img src="{{asset('icons/zyco4.png')}}" alt="AdminLTE Docs Logo Small"
                    class="brand-image-xl logo-xs" style="left: 25px;">>
                <img src="{{asset('site_pic/'.$site_config->site_logo)}}" alt="AdminLTE Docs Logo Large"
                    class="brand-image-xs logo-xl" style="left: 35px;">
            </a>
        </div>
        <div class="col-3">
            <div class="sidenavbar-company-name brand-text">
                {{$site_config->brand_name}}
            </div>
        </div>
        <div class=" col-4"> <a class="btn btn-warning text-white btn-sm brand-text  profile_status"
                href="#"><span>Admin</span></a></div>
        <div class="col-2">


        </div>
        <div class="sidebar ">

            <!-- Sidebar user panel (optional) -->
            <!-- </a>-->
            <!-- Sidebar Menu -->
            <a href="#" onclick="divmenu('general')" class="text-center">
                <div class="col-4 ">
                    <i class="fa-solid fa-arrow-left text-primary"></i>
                </div>
            </a>
            <nav class="mt-2 sidetext sidebak">

                <ul class="nav nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                    style="padding-bottom: 12rem;">
                    @if(Auth::guard('admin')->check())
                    @include('backend.admin_menus')
                    @endif

                </ul>

            </nav>
        </div>
</aside>

<script type="text/javascript">
function my_toggle_button_admin() {


    $('#my-toggle-button-admin').find("i").toggleClass('pushmenu brand-text fas fa-angles-left');

    $('#my-toggle-button-admin').find("i").toggleClass('pushmenu brand-text fas fa-angles-right');

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
var path = "{{ route('autocomplete') }}";

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
</script>