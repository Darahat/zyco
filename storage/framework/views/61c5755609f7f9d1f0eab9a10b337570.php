

<?php $__env->startSection('title', 'Sign In Options'); ?>

<?php $__env->startSection('content'); ?>
<div class="row bg-white">
    <div class="col-md-7">
        <div class="hold-transition login-page loginSideDiv">
            <img src="<?php echo e(asset('images/Group 455.png')); ?>" alt="login_image" class="loginSideImage">
        </div>
    </div>
    <div class="col-md-5 col-sm-12">
        <div class="hold-transition login-page">
            <div class="login-box">
                <div class="text-center">
                    <img src="<?php echo e(asset('icons/zyco.png')); ?>" style="height:75px">
                    <h4 class="mt-3">Having Trouble Signing In?</h4>
                    <p class="text-muted">Choose an option to recover your account</p>
                </div>
                <div class="list-group">
                    <a href="<?php echo e(route('forget_password')); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-key"></i> Forgot Password
                    </a>
                    <a href="<?php echo e(route('forget_email')); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-envelope"></i> Forgot Email
                    </a>
                    <a href="<?php echo e(route('login')); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-arrow-left"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Dream\Laravel Deep Learning\zyco\resources\views/auth/signin_option.blade.php ENDPATH**/ ?>