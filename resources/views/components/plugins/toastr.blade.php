{{-- Toastr Notification Plugin --}}
@once
    @push('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    @endpush

    @push('plugin-scripts')
        <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
        
        {{-- Auto-display Laravel session messages --}}
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
        </script>
    @endpush
@endonce
