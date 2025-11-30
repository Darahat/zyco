
<?php if (! $__env->hasRenderedOnce('718157e4-6bce-4790-8970-1ca7ac666d78')): $__env->markAsRenderedOnce('718157e4-6bce-4790-8970-1ca7ac666d78'); ?>
    <?php $__env->startPush('plugin-styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/toastr/toastr.min.css')); ?>">
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('plugin-scripts'); ?>
        <script src="<?php echo e(asset('assets/plugins/toastr/toastr.min.js')); ?>"></script>
        
        
        <script>
        <?php if(Session::has('status')): ?>
        var type = "<?php echo e(Session::get('alert-type','info')); ?>";
        switch (type) {
            case 'info':
                toastr.info("<?php echo e(Session::get('status')); ?>");
                break;
            case 'success':
                toastr.success("<?php echo e(Session::get('status')); ?>");
                break;
            case 'warning':
                toastr.warning("<?php echo e(Session::get('status')); ?>");
                break;
            case 'error':
                toastr.error("<?php echo e(Session::get('status')); ?>");
                break;
        }
        <?php endif; ?>
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH D:\Dream\Laravel Deep Learning\zyco\resources\views/components/plugins/toastr.blade.php ENDPATH**/ ?>