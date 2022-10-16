<!DOCTYPE html>
<html>

    <head>
        <title>Zyco</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">



        <!-- Ionicons -->
        <!-- icheck bootstrap -->

        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">

        <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
        {{-- custom auth pages csss --}}
        <link rel="stylesheet" href="{{ asset('public/assets/css/auth.css') }}">
        <!-- Google Font: Source Sans Pro -->

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- SweetAlert2 -->
        <link rel="stylesheet"
            href="{{ asset('public/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/toastr/toastr.min.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet"
            href="{{ asset('public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('public/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet"
            href="{{ asset('public/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- JQVMap -->
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/jqvmap/jqvmap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('public/assets/dist/css/adminlte.min.css') }}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/summernote/summernote-bs4.min.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet"
            href="{{ asset('public/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/daterangepicker/daterangepicker.css') }}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/summernote/summernote-bs4.min.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        {{-- <script src="https://www.google.com/recaptcha/api.js"></script> --}}
        <script src="https://www.google.com/recaptcha/api.js?render=6LdYQQ8hAAAAAH1qvC4ufbT_8nFcRIIJ6M2o8ZBG"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital@0;1&family=Tiro+Bangla&display=swap"
            rel="stylesheet">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> -->
    </head>
    <style>
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

    .login-box {
        width: 410px;
    }
    </style>

    <body>

        @yield('content')

        <!-- jQuery -->
        {{-- <script src="{{ asset('public/assets/plugins/jquery/jquery.min.js') }}"></script> --}}

        <!-- jQuery UI 1.11.4 -->
        {{-- <script src="{{ asset('public/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script> --}}
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        {{-- <script>
          $.widget.bridge('uibutton', $.ui.button)
        </script> --}}
        // firebase

        <!-- Bootstrap 4 -->

        <script src="{{ asset('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- DataTables  & Plugins -->
        <script src="{{ asset('public/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
        </script>
        <script src="{{ asset('public/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
        </script>
        <script src="{{ asset('public/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

        <!-- ChartJS -->
        <script src="{{ asset('public/assets/plugins/chart.js/Chart.min.js') }}"></script>
        <!-- Sparkline -->
        <script src="{{ asset('public/assets/plugins/sparklines/sparkline.js') }}"></script>
        <!-- JQVMap -->
        <script src="{{ asset('public/assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset('public/assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
        <!-- daterangepicker -->
        <script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('public/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script
            src="{{ asset('public/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
        </script>
        <!-- Summernote -->
        <script src="{{ asset('public/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('public/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
        </script>
        <!-- SweetAlert2 -->
        <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <!-- Toastr -->
        <script src="{{ asset('public/assets/plugins/toastr/toastr.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('public/assets/dist/js/adminlte.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('public/assets/dist/js/demo.js') }}"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{ asset('public/assets/dist/js/pages/dashboard.js') }}"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> -->
        <script src="{{ asset('public/assets/dist/js/adminlte.min.js') }}"></script>




        <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-app.js" type="module"></script>
        <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-analytics.js" type="module"> </script>
        <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-auth.js" type="module"></script>
        <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-firestore.js" type="module"></script>




        <script>
        const firebaseConfig = {
            apiKey: "AIzaSyDtspAOAZwhA4sa4h1R5a9jakDpHBdABgU",
            authDomain: "zyco-bv.firebaseapp.com",
            databaseURL: "https://zyco-bv-default-rtdb.europe-west1.firebasedatabase.app",
            projectId: "zyco-bv",
            storageBucket: "zyco-bv.appspot.com",
            messagingSenderId: "791897542307",
            appId: "1:791897542307:web:06f4d8659e8506fb99b916",
            measurementId: "G-J6744PF13K"
        };

        // Initialize Firebase
        const app = firebase.initializeApp(firebaseConfig);
        // const analytics = getAnalytics(app);

        appCheck.activate(
            '6LdYQQ8hAAAAAOI1IW9SSIRaGZzI1m6yYFyX4vtm',
            // Optional argument. If true, the SDK automatically refreshes App Check
            // tokens as needed.
            true);
        </script>

        <script>
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
                toastr.warning("{{ Session::get('status') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('status') }}");
                break;
        }
        @endif
        $(document).ready(function() {
            $('#myTable').DataTable();
        });


        $(document).ready(function() {
            window.localLinkClicked = false;

            $("a").live("click", function() {
                var url = $(this).attr("href");

                // check if the link is relative or to your domain
                if (!/^https?:\/\/./.test(url) || /https?:\/\/yourdomain\.com/.test(url)) {
                    window.localLinkClicked = true;
                }
            });

            window.onhashchange = function() {
                if (window.innerDocClick) {
                    window.innerDocClick = false;
                } else {
                    if (window.location.hash != '#undefined') {
                        goBack();
                    } else {
                        history.pushState("", document.title, window.location.pathname);
                        location.reload();
                    }
                }
            }
        });
        </script>
        {{-- Auth related js --}}
        <script>
        function phoneSendAuth(number) {
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {

                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                console.log(coderesult);
                let reg = /.{1,10}/
                $("#sentSuccess").text("Enter the code we sent to your mobile " + number.replace(reg, (m) => "X"
                    .repeat(m.length)));
                $("#sentSuccess").show();

            }).catch(function(error) {
                $("#errorOtp").text(error.message);
                $("#error").text(error.message);
                $("#error").show();
            });
        }


        function waitToGoDashboard() {
            setTimeout(sendToDashboardNow, 5000)
        }
        $("#VerificationCodeSubmit").click(function() {
            return codeverify();
        })
        $("#resendOtp").click(function() {
            // alert(getMobileNumber);

            return phoneSendAuth(getMobileNumber);
        })

        function onSubmit(token) {
            // alert(token);
            document.getElementById("demo-form").submit();
        }
        </script>
    </body>

</html>