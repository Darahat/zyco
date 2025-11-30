

<?php if (! $__env->hasRenderedOnce('e942a1ec-42f8-4239-af02-18bc458190c0')): $__env->markAsRenderedOnce('e942a1ec-42f8-4239-af02-18bc458190c0'); ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
    // Firebase Phone Authentication Helper (old SDK style)
    function phoneSendAuth(number) {
        if (!firebase || !firebase.auth) {
            console.error('Firebase not properly initialized. Did you include <?php if (isset($component)) { $__componentOriginalf3c5b03d8ddc17b5f33d244697b75af2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3c5b03d8ddc17b5f33d244697b75af2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.plugins.firebase','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('plugins.firebase'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3c5b03d8ddc17b5f33d244697b75af2)): ?>
<?php $attributes = $__attributesOriginalf3c5b03d8ddc17b5f33d244697b75af2; ?>
<?php unset($__attributesOriginalf3c5b03d8ddc17b5f33d244697b75af2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3c5b03d8ddc17b5f33d244697b75af2)): ?>
<?php $component = $__componentOriginalf3c5b03d8ddc17b5f33d244697b75af2; ?>
<?php unset($__componentOriginalf3c5b03d8ddc17b5f33d244697b75af2); ?>
<?php endif; ?>?');
            return;
        }
        
        firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {
            window.confirmationResult = confirmationResult;
            window.coderesult = confirmationResult;
            console.log('OTP sent successfully');
            
            let reg = /.{1,10}/;
            $("#sentSuccess").text("Enter the code we sent to your mobile " + number.replace(reg, (m) => "X".repeat(m.length)));
            $("#sentSuccess").show();
        }).catch(function(error) {
            console.error('Firebase OTP error:', error);
            $("#errorOtp").text(error.message);
            $("#error").text(error.message);
            $("#error").show();
        });
    }

    // Helper for reCAPTCHA submission
    function onSubmit(token) {
        if (document.getElementById("demo-form")) {
            document.getElementById("demo-form").submit();
        }
    }

    // Wait before redirecting to dashboard
    function waitToGoDashboard() {
        setTimeout(sendToDashboardNow, 5000);
    }
    </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH D:\Dream\Laravel Deep Learning\zyco\resources\views/components/plugins/firebase-auth-helpers.blade.php ENDPATH**/ ?>