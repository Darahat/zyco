<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page_title }}</title>
        {{-- custom auth pages csss --}}
        {{-- <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}"> --}}
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/bs-stepper/css/bs-stepper.min.css')}}">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        {{-- custom CSS --}}
        <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- MDB -->
        <!-- bootstrap_select css-->
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
        <!-- Toastr -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet"
            href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/plugins/datatables-searchbuilder/css/searchBuilder.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        <script type="text/javascript"
            src="https://cdn.datatables.net/colreorder/1.5.6/css/colReorder.dataTables.min.css"></script>
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet"
            href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- JQVMap -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet"
            href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
        <!-- jQuery -->

        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

        <link rel="stylesheet" href="{{asset('assets/css/user-profile-update.css')}}" />
        <!-- jQuery UI 1.11.4 -->

        <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- DataTables  & Plugins -->

        <!-- MDB -->

        {{-- <script  type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script> --}}

        <link rel="stylesheet" href="{{ asset('assets/plugins/colorpicker/jquery.colorpicker.css') }}" />

        <script src="{{ asset('assets/plugins/colorpicker/jquery.colorpicker.js') }}"></script>

    </head>

    <style>
    .bottom-border-of-nav {
        width: 80%;
    }

    .btn-primary,
    .btn-primary:hover,
    .btn-primary:active,
    .btn-primary:visited {
        background-color: #00B3F9 !important;
        border: 1px solid #00B3F9 !important;
    }

    .primary-color {

        background-color: #00B3F9 !important;

        color: white !important;

    }

    @font-face {
        font-family: 'lato';
        font-style: normal;
        src: url('../public/assets/fonts/lato/Lato-Regular.ttf');
    }

    html,
    body {
        font-family: lato !important;
        background-color: #F5F7F9;
    }

    .content-wrapper {
        background-color: #F5F7F9;
    }
    </style>
    <!--sidebar-collapse -->

    <body class="sidebar-mini  layout-fixed layout-footer-fixed   ">

        <div class="wrapper">
            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="{{ asset('icons/zyco4.png') }}" alt="AdminLTELogo"
                    height="100" width="100">
            </div>

            <!-- Navbar -->
            @if(Auth::user())
            @include('backend.navbar')
            @include('backend.nav_sidebar')
            @php
            $theme_top_text = Auth::user()->theme_top_text;
            $theme_top_bg = Auth::user()->theme_top_bg;
            $theme_side_text = Auth::user()->theme_side_text;
            $theme_side_bg = Auth::user()->theme_side_bg;
            @endphp
            @else
            @include('backend.navbarAdmin')
            @include('backend.navSidebarAdmin')
            @php
            $theme_top_text = "#FFFFFF";
            $theme_top_bg = "#FFFFFF";
            $theme_side_text = "#FFFFFF";
            $theme_side_bg = "#FFFFFF";
            @endphp

            @endif
            <div style="margin-left:16.625rem;margin-right:2.604rem">
                <hr />
            </div>
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->

            @yield('content')



            <!-- /.content-wrapper -->

            <!--<footer class="main-footer">
    <strong>Developed by- <a href="#" target="_blank">Taxi Plaza Developer Team</a></strong>
    <div class="float-right d-none d-sm-inline-block">    
    </div>
  </footer> -->



            <!-- Control Sidebar -->

            <aside class="control-sidebar control-sidebar-dark">

                <!-- Control sidebar content goes here -->
                <div class="p-3">
                    <h4>Customize</h5>
                        <table width="100%">
                            <tr>
                                <td colspan="2" class="text-center bg-warning">Top Bar</td>

                            </tr>
                            <tr>
                                <td>Text</td>
                                <td>
                                    <div class="btn-group btn-block">
                                        <input type="color" class="form-control form-control-sm form-control-color"
                                            name="top_text" value="{{ $theme_top_text}}"
                                            onchange="theme_customize('top_text',this.value)" title="Choose your color"
                                            id="top_text">
                                        <button class="btn btn-default btn-sm" name="top_text"
                                            value="{{ $theme_top_text}}" onclick="theme_customize('top_text','')"
                                            title="Set Default" id="top_text"><i class="fas fa-redo fa-sm"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Background</td>
                                <td>
                                    <div class="btn-group btn-block">
                                        <input type="color" class="form-control form-control-sm form-control-color"
                                            name="top_bg" value="{{ $theme_top_bg}}"
                                            onchange="theme_customize('top_bg',this.value)" title="Choose your color"
                                            id="top_bak">
                                        <button class="btn btn-default btn-sm" name="top_text"
                                            value="{{ $theme_top_bg}}" onclick="theme_customize('top_bg','')"
                                            title="Set Default" id="top_text"><i class="fas fa-redo fa-sm"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table width="100%">
                            <tr>
                                <td colspan="2" class="text-center bg-warning">Side Bar</td>
                            </tr>
                            <tr>
                                <td>Text</td>
                                <td>
                                    <div class="btn-group btn-block">
                                        <input type="color" class="form-control form-control-sm form-control-color"
                                            name="side_text" value="{{ $theme_side_text}}"
                                            onchange="theme_customize('side_text',this.value)"
                                            title="Choose your color">
                                        <button class="btn btn-default btn-sm" name="top_text"
                                            value="{{ $theme_side_text}}" onclick="theme_customize('side_text','')"
                                            title="Set Default" id="top_text"><i class="fas fa-redo fa-sm"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Background</td>
                                <td>
                                    <div class="btn-group btn-block">
                                        <input type="color" class="form-control form-control-sm form-control-color"
                                            name="side_bg" value="{{ $theme_side_bg}}"
                                            onchange="theme_customize('side_bg',this.value)" title="Choose your color">
                                        <button class="btn btn-default btn-sm" name="top_text"
                                            value="{{ $theme_side_bg}}" onclick="theme_customize('side_bg','')"
                                            title="Set Default" id="top_text"><i class="fas fa-redo fa-sm"></i></button>
                                    </div>

                                </td>
                            </tr>
                        </table>

                </div>

            </aside>
            <!-- /.control-sidebar -->

            <!-- ./wrapper -->
            <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

            <!-- Bootstrap 4 -->

            <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <!-- DataTables  & Plugins -->
            <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
            </script>
            <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
            </script>
            <script
                src="{{ asset('assets/plugins/datatables-searchbuilder/js/dataTables.searchBuilder.min.js') }}">
            </script>
            <script
                src="{{ asset('assets/plugins/datatables-searchbuilder/js/searchBuilder.bootstrap4.min.js') }}">
            </script>
            <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
            <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
            <script src="https://cdn.datatables.net/colreorder/1.5.6/js/dataTables.colReorder.min.js"></script>

            {{-- custom js  --}}
            <!-- ChartJS -->
            <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
            <!-- Sparkline -->
            <script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
            <!-- JQVMap -->
            <script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
            <!-- jQuery Knob Chart -->
            <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
            <!-- daterangepicker -->
            <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>

            <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

            <!-- Tempusdominus Bootstrap 4 -->

            <script
                src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
            </script>

            <!-- Summernote -->

            <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

            <!-- overlayScrollbars -->

            <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
            </script>



            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

            <!-- Toastr -->

            <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

            <!-- AdminLTE App -->

            <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>

            <!-- AdminLTE for demo purposes -->

            {{--<script src="{{ asset('assets/dist/js/demo.js') }}"></script>--}}

            <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js">
            </script>

            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <!-- 
<script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/RubaXa/Sortable/Sortable.min.js"></script>
 <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
 <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-app.js" type = "module"></script>
 <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-analytics.js" type="module"> </script>
 <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-auth.js" type = "module"></script>
 <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-firestore.js" type="module"></script>
 <script type="module" src="{{ asset('assets/js/admin.js') }}"></script> 
<script src="https://zyco-bv.firebaseio.com/"></script>-->

            <link rel="stylesheet" href="{{ asset('assets/plugins/bs-stepper/js/bs-stepper.min.js')}}">


            <script>
            function openForm() {
                document.getElementById("myForm").style.display = "block";
            }

            function closeForm() {
                document.getElementById("myForm").style.display = "none";
            }

            @if(Session::has('status'))
            var type = "{{Session::get('alert-type','info')}}";
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('status') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('status') }}");
                    break;
                case 'warning':
                    toastr.succewarningss("{{ Session::get('status') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('status') }}");
                    break;
            }

            @endif

            $('.delete-confirm').on('click', function(event) {
                event.preventDefault();
                const url = $(this).attr('href');
                swal({
                    title: 'Are you sure?',
                    text: 'This record will be permanantly deleted!',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        window.location.href = url;
                    }
                });
            });
            </script>

            <script>
            $(function() {
                // Multiple images preview with JavaScript

                var multiImgPreview = function(input, imgPreviewPlaceholder) {
                    if (input.files) {
                        var filesAmount = input.files.length;
                        for (i = 0; i < filesAmount; i++) {
                            var reader = new FileReader();
                            reader.onload = function(event) {
                                $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                                    imgPreviewPlaceholder);
                            }
                            reader.readAsDataURL(input.files[i]);
                        }
                    }
                };
                $('#images').on('change', function() {
                    multiImgPreview(this, 'div.imgPreview');
                });
            });
            </script>

            <script>
            $(function() {
                // Summernote
                $('#summernote').summernote({
                    placeholder: 'Enter your text here',
                    tabsize: 2,
                    height: 300
                })
            })
            </script>
            <script>
            $(function() {
                $('#top_text').change(function() {
                    $('.toptext').css('background-color', $('#top_text').val());
                });

                $('#top_bak').change(function() {
                    $('.topbak').css('background-color', $('#top_bak').val());
                });
                $('#side_text').change(function() {
                    $('.sidetext').css('background-color', $('#side_text').val());
                });

                $('#side_bak').change(function() {
                    $('.sidebak').css('background-color', $('#side_bak').val());
                });
            })

            function theme_customize(type, color) {
                $(document).ready(function() {
                    $.ajax({
                        type: "POST",
                        url: "<?= route('theme_customize') ?>",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            type: type,
                            color: color
                        },
                        success: function(data) {

                            window.location.reload();
                        },
                        error: function(data) {

                        }
                    });
                });
            }
            </script>
            <style>
            .newpost {
                display: block;
            }

            div.dataTables_wrapper div.dt-buttons.btn-group div.btn-group button.dt-btn-split-drop:last-child {
                background-color: #f8f9fa;
                color: #444;
                border: 1px solid #ddd;
            }
            </style>
            <script>
            $(document).ready(function() {
                document.addEventListener('DOMContentLoaded', function() {
                    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
                })
            })
            </script>
            <script>
            function deleteSingleData(id, table_name) {
                $(document).ready(function() {
                    $.ajax({
                        type: "POST",
                        url: '<?= route("deleteSingleData") ?>',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id,
                            table: table_name
                        },
                        success: function(data) {
                            window.location.reload();
                        },
                        error: function(data) {

                        }
                    });
                });
            }

            function updateSingleData(id, table_name, field_name, field_value) {
                $(document).ready(function() {
                    $.ajax({
                        type: "POST",
                        url: '<?= route("updateSingleData") ?>',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id,
                            table: table_name,
                            field: field_name,
                            value: field_value
                        },
                        success: function(data) {
                            window.location.reload();
                        },
                        error: function(data) {}
                    });
                });
            }
            $(document).ready(function() {
                // $('#example1 tfoot th').each(function () {
                //       var title = $(this).text();
                //       $(this).html('<input type="text" class="newpost form-control" placeholder="Search ' + title + '" />');
                //   });
                var table2 = $(".datatable2").DataTable({
                    language: {
                        searchBuilder: {
                            button: {
                                0: '<i class="fas fa-search"></i>',
                                1: '<i class="fas fa-search"></i> Search/Filter',
                                _: '<i class="fas fa-search"></i> (%d)'
                            }
                        }
                    },
                    colVis: {
                        "exclude": [0],
                        "sAlign": "right",
                        "bRestore": true,
                    },
                    columnDefs: [{
                            width: 20,
                            targets: 0
                        },
                        {
                            width: 20,
                            targets: 1
                        },
                    ],

                    // "processing": true,

                    // "serverSide": true,

                    // "ajax": 'route("statusChange")',
                    "fixedColumns": true,

                    "dom": "Bfrtip",

                    "paging": true,

                    "lengthChange": true,

                    "stateSave": true,

                    "searching": true,

                    "colReorder": true,

                    "info": true,

                    "autoWidth": false,

                    "text": 'Refresh',

                    "responsive": true,

                    "select": true,

                    "fixedColumns": {

                        "left": 1,

                    },

                    "buttons": [





                        {

                            extend: 'colvis',

                            className: 'btn btn-default',

                            text: '<i class="fas fa-eye"></i>',

                            titleAttr: 'colvis',

                            columns: ':gt(1)',



                        },

                        {

                            titleAttr: 'reset',

                            className: 'btn btn-default',

                            text: '<i class="fas fa-rotate-left"></i>',

                            action: function(e, dt, node, config) {

                                // dt.colReorder.reset();

                                dt.state.clear();

                                window.location.reload();

                            }
                        },

                        {

                            titleAttr: 'refresh',

                            className: 'btn btn-default',

                            text: '<i class="fas fa-arrows-rotate"></i>',

                            action: function(e, dt, node, config) {

                                dt.search('');

                                dt.columns().search('').draw();



                            }
                        },



                        {

                            extend: 'searchBuilder',

                            text: '<i class="fas fa-search"></i>',

                            className: 'btn btn-default',

                            titleAttr: 'Custom Filter',

                        },





                    ],



                })


                var table = $(".datatable").DataTable({





                    language: {

                        searchBuilder: {

                            button: {

                                0: '<i class="fas fa-search"></i>',

                                1: '<i class="fas fa-search"></i> Search/Filter',

                                _: '<i class="fas fa-search"></i> (%d)'

                            }

                        }

                    },

                    colVis: {

                        "exclude": [0],

                        "sAlign": "right",

                        "bRestore": true,



                    },

                    columnDefs: [

                        {
                            width: 20,
                            targets: 0
                        },

                        {
                            width: 20,
                            targets: 1
                        },

                    ],

                    // "processing": true,

                    // "serverSide": true,

                    // "ajax": 'route("statusChange")',



                    "fixedColumns": true,

                    "dom": "Bfrtip",

                    "paging": true,

                    "lengthChange": true,

                    "stateSave": true,

                    "searching": true,

                    "colReorder": true,

                    "info": true,

                    "autoWidth": false,

                    "text": 'Refresh',

                    "responsive": true,

                    "select": true,

                    "fixedColumns": {

                        "left": 1,

                    },

                    "buttons": [



                        {

                            titleAttr: 'Add',

                            text: '<i class="fas fa-plus"></i>',

                            className: 'btn btn-default',

                            action: function(e, dt, node, config) {

                                $('.addform').modal('show');

                            }

                        },

                        {

                            extend: 'colvis',

                            className: 'btn btn-default',

                            text: '<i class="fas fa-eye"></i>',

                            titleAttr: 'colvis',

                            columns: ':gt(1)',



                        },

                        {

                            titleAttr: 'reset',

                            className: 'btn btn-default',

                            text: '<i class="fas fa-rotate-left"></i>',

                            action: function(e, dt, node, config) {

                                // dt.colReorder.reset();

                                dt.state.clear();

                                window.location.reload();

                            }
                        },

                        {

                            titleAttr: 'refresh',

                            className: 'btn btn-default',

                            text: '<i class="fas fa-arrows-rotate"></i>',

                            action: function(e, dt, node, config) {

                                dt.search('');

                                dt.columns().search('').draw();



                            }
                        },

                        {

                            extend: 'collection',

                            text: '<i class="fa-solid fa-download"></i>',

                            className: 'btn btn-default',

                            buttons: [

                                {

                                    extend: 'csv',

                                    text: '<i class="fas fa-file-csv"></i> CSV',

                                    className: 'btn btn-primary',

                                    titleAttr: 'CSV',



                                },

                                {

                                    extend: 'excel',

                                    text: '<i class="fa-solid fa-file-excel"></i> Excel',

                                    className: 'btn btn-primary',

                                    titleAttr: 'Excel',

                                },

                                {

                                    extend: 'pdf',

                                    text: '<i class="fa-solid fa-file-pdf"></i> PDF',

                                    className: 'btn btn-primary',

                                    titleAttr: 'PDF',

                                },

                                {

                                    extend: 'copy',

                                    text: '<i class="fa-solid fa-copy"></i> Copy',

                                    className: 'btn btn-primary',

                                    titleAttr: 'Copy',

                                },

                                {

                                    extend: 'print',

                                    text: '<i class="fa-solid fa-print"></i> Print',

                                    className: 'btn btn-primary',

                                    titleAttr: 'Print',

                                },

                            ]
                        },

                        {

                            extend: 'searchBuilder',

                            text: '<i class="fas fa-search"></i>',

                            className: 'btn btn-default',

                            titleAttr: 'Custom Filter',

                        },





                    ],



                })





            })
            </script>

            <script>
            function closeAllModal()

            {

                $(document).ready(function() {

                    $('.modal').modal('hide');
                })
            }
            </script>

            <script>
            var url = window.location;



            // for sidebar menu entirely but not cover treeview

            $('.dashboard .nav-item a').filter(function() {

                return this.href == url;

            }).addClass('');

            $('.sidebar .nav-item a').filter(function() {

                return this.href == url;

            }).addClass('active');

            // for treeview

            $('ul.nav-treeview a').filter(function() {

                return this.href == url;

            }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');

            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
            </script>

    </body>

</html>