{{-- Summernote WYSIWYG Editor Plugin --}}
@once
    @push('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
    @endpush

    @push('plugin-scripts')
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    @endpush
@endonce
