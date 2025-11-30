{{-- Firebase Authentication Plugin - Compatibility mode for old firebase SDK syntax --}}
@once
    @push('plugin-scripts')
        <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-analytics.js"></script>
        <script>
            // Firebase configuration
            const firebaseConfig = {
                apiKey: "{{ env('FIREBASE_API_KEY', 'AIzaSyCEGfUWDFTUDuXcHFSuIKogpmWG5HHl9kw') }}",
                authDomain: "{{ env('FIREBASE_AUTH_DOMAIN', 'zyco-bv.firebaseapp.com') }}",
                databaseURL: "{{ env('FIREBASE_DATABASE_URL', 'https://zyco-bv-default-rtdb.europe-west1.firebasedatabase.app') }}",
                projectId: "{{ env('FIREBASE_PROJECT_ID', 'zyco-bv') }}",
                storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET', 'zyco-bv.firebasestorage.app') }}",
                messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID', '791897542307') }}",
                appId: "{{ env('FIREBASE_APP_ID', '1:791897542307:web:16ccac36e1a667f999b916') }}",
                measurementId: "{{ env('FIREBASE_MEASUREMENT_ID', 'G-WVPY5CBPBP') }}"
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
    @endpush
@endonce
