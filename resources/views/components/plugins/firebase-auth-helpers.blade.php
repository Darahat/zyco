{{-- Firebase Auth Helper Functions --}}
{{-- Include this after <x-plugins.firebase /> to get helper functions --}}
@once
    @push('scripts')
    <script>
    // Firebase Phone Authentication Helper (old SDK style)
    function phoneSendAuth(number) {
        if (!firebase || !firebase.auth) {
            console.error('Firebase not properly initialized. Did you include <x-plugins.firebase />?');
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
    @endpush
@endonce
