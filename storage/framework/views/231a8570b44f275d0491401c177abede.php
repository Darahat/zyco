
<?php if (! $__env->hasRenderedOnce('9d57fe3b-7682-4977-811e-b3cc6ec3794e')): $__env->markAsRenderedOnce('9d57fe3b-7682-4977-811e-b3cc6ec3794e'); ?>
    <?php $__env->startPush('plugin-scripts'); ?>
        <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-analytics.js"></script>
        <script>
            // Firebase configuration
            const firebaseConfig = {
                apiKey: "<?php echo e(env('FIREBASE_API_KEY', 'AIzaSyCEGfUWDFTUDuXcHFSuIKogpmWG5HHl9kw')); ?>",
                authDomain: "<?php echo e(env('FIREBASE_AUTH_DOMAIN', 'zyco-bv.firebaseapp.com')); ?>",
                databaseURL: "<?php echo e(env('FIREBASE_DATABASE_URL', 'https://zyco-bv-default-rtdb.europe-west1.firebasedatabase.app')); ?>",
                projectId: "<?php echo e(env('FIREBASE_PROJECT_ID', 'zyco-bv')); ?>",
                storageBucket: "<?php echo e(env('FIREBASE_STORAGE_BUCKET', 'zyco-bv.firebasestorage.app')); ?>",
                messagingSenderId: "<?php echo e(env('FIREBASE_MESSAGING_SENDER_ID', '791897542307')); ?>",
                appId: "<?php echo e(env('FIREBASE_APP_ID', '1:791897542307:web:16ccac36e1a667f999b916')); ?>",
                measurementId: "<?php echo e(env('FIREBASE_MEASUREMENT_ID', 'G-WVPY5CBPBP')); ?>"
            };

            // Initialize Firebase (old SDK style)
            if (!firebase.apps.length) {
                firebase.initializeApp(firebaseConfig);
            }
            
            // Initialize Analytics
            if (typeof firebase.analytics === 'function') {
                firebase.analytics();
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH D:\Dream\Laravel Deep Learning\zyco\resources\views/components/plugins/firebase.blade.php ENDPATH**/ ?>