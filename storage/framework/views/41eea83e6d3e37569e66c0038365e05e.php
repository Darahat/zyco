<!DOCTYPE html>
<html>

    <head>
        <title>Zyco - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital@0;1&family=Tiro+Bangla&display=swap" rel="stylesheet">

        <!-- Core CSS - Always loaded -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/auth.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fontawesome-free/css/all.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/dist/css/adminlte.min.css')); ?>">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

        <!-- Conditional Plugin CSS - Load only when needed -->
        <?php echo $__env->yieldPushContent('plugin-styles'); ?>

        <!-- Page-specific CSS -->
        <?php echo $__env->yieldPushContent('styles'); ?>

        <!-- Core JS - jQuery loaded early -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <style>
    html,
    body {
        font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        background-color: #F5F7F9;
    }

    .login-box {
        width: 410px;
    }
    </style>

    <body>

        <?php echo $__env->yieldContent('content'); ?>

        <!-- Core Scripts - Always loaded -->
        <script src="<?php echo e(asset('assets/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/dist/js/adminlte.min.js')); ?>"></script>

        <!-- Conditional Plugin Scripts - Load only when needed -->
        <?php echo $__env->yieldPushContent('plugin-scripts'); ?>

        <!-- Page-specific Scripts -->
        <?php echo $__env->yieldPushContent('scripts'); ?>

        
        <script>
        // Back button handling
        $(document).ready(function() {
            window.localLinkClicked = false;

            $(document).on("click", "a", function() {
                var url = $(this).attr("href");
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
    </body>

</html><?php /**PATH D:\Dream\Laravel Deep Learning\zyco\resources\views/app.blade.php ENDPATH**/ ?>