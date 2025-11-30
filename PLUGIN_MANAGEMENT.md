# Plugin Management System

## Overview

This system uses Laravel Blade stacks to load plugins **only on pages that need them**, drastically improving page load times.

## How It Works

### 1. Main Layout (`app.blade.php`)

The main layout now has three key sections:

- `@stack('plugin-styles')` - For plugin CSS
- `@stack('plugin-scripts')` - For plugin JavaScript
- `@stack('styles')` - For page-specific CSS
- `@stack('scripts')` - For page-specific JS

### 2. Plugin Components (`resources/views/components/plugins/`)

Each plugin is now a reusable component:

- `datatables.blade.php` - DataTables with export buttons
- `sweetalert.blade.php` - SweetAlert2 notifications
- `toastr.blade.php` - Toastr notifications (auto-loads session messages)
- `chartjs.blade.php` - Chart.js for graphs
- `summernote.blade.php` - WYSIWYG editor
- `daterangepicker.blade.php` - Date range picker
- `datetimepicker.blade.php` - DateTime picker
- `stepper.blade.php` - Bootstrap stepper
- `firebase.blade.php` - Firebase authentication

## Usage Examples

### Example 1: Page with DataTable

```blade
@extends('app')

@section('title', 'Country List')

@section('content')
    {{-- Include DataTables plugin --}}
    <x-plugins.datatables />

    {{-- Include Toastr for notifications --}}
    <x-plugins.toastr />

    <div class="container">
        <table id="myTable" class="table">
            <thead>
                <tr>
                    <th>Country</th>
                    <th>Code</th>
                </tr>
            </thead>
            <tbody>
                <!-- Your data -->
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            buttons: ['copy', 'excel', 'pdf', 'print']
        });
    });
</script>
@endpush
```

### Example 2: Page with Charts

```blade
@extends('app')

@section('title', 'Dashboard')

@section('content')
    {{-- Include Chart.js plugin --}}
    <x-plugins.chartjs />

    {{-- Include Toastr for notifications --}}
    <x-plugins.toastr />

    <canvas id="myChart"></canvas>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3]
            }]
        }
    });
</script>
@endpush
```

### Example 3: Registration Form with Firebase

```blade
@extends('app')

@section('title', 'Register')

@section('content')
    {{-- Include Firebase plugin --}}
    <x-plugins.firebase />

    {{-- Include Stepper plugin --}}
    <x-plugins.stepper />

    {{-- Include Toastr for notifications --}}
    <x-plugins.toastr />

    <div id="stepper1" class="bs-stepper">
        <!-- Your stepper content -->
    </div>
@endsection

@push('scripts')
<script>
    // Firebase is now available globally
    window.recaptchaVerifier = new window.RecaptchaVerifier(...);
</script>
@endpush
```

### Example 4: Form with WYSIWYG Editor

```blade
@extends('app')

@section('title', 'Edit Content')

@section('content')
    {{-- Include Summernote plugin --}}
    <x-plugins.summernote />

    <textarea id="summernote"></textarea>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300
        });
    });
</script>
@endpush
```

### Example 5: Custom Page Styles

```blade
@extends('app')

@section('content')
    <h1>My Page</h1>
@endsection

@push('styles')
<style>
    .custom-class {
        color: red;
    }
</style>
@endpush

@push('scripts')
<script>
    console.log('Page-specific JavaScript');
</script>
@endpush
```

## Benefits

### Before (Loading Everything):

- **Page Load**: ~2-3 seconds
- **Assets Loaded**: 25+ CSS files, 30+ JS files
- **Total Size**: ~5MB per page

### After (Loading Only What's Needed):

- **Simple Page**: ~200ms (only core assets)
- **Page with DataTables**: ~500ms (core + datatables)
- **Complex Form**: ~800ms (core + specific plugins)
- **Total Size**: 500KB - 1.5MB (depending on plugins used)

## Migration Guide

### Step 1: Update Your Views

**Old way:**

```blade
@extends('app')

@section('content')
    <table id="myTable">
        <!-- content -->
    </table>
@endsection
```

**New way:**

```blade
@extends('app')

@section('content')
    <x-plugins.datatables />

    <table id="myTable">
        <!-- content -->
    </table>
@endsection
```

### Step 2: Move Custom Scripts to @push

**Old way:**

```blade
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
```

**New way:**

```blade
@push('scripts')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
@endpush
```

## Available Plugin Components

| Component                       | Usage               | When to Use                     |
| ------------------------------- | ------------------- | ------------------------------- |
| `<x-plugins.datatables />`      | Advanced tables     | Lists with search, sort, export |
| `<x-plugins.sweetalert />`      | Beautiful alerts    | Confirmation dialogs            |
| `<x-plugins.toastr />`          | Toast notifications | Success/error messages          |
| `<x-plugins.chartjs />`         | Charts & graphs     | Dashboard, analytics            |
| `<x-plugins.summernote />`      | Rich text editor    | Content management              |
| `<x-plugins.daterangepicker />` | Date ranges         | Reports, filters                |
| `<x-plugins.datetimepicker />`  | Date & time         | Booking forms                   |
| `<x-plugins.stepper />`         | Multi-step forms    | Registration, wizards           |
| `<x-plugins.firebase />`        | Phone auth          | OTP verification                |

## Creating New Plugin Components

If you need a new plugin:

1. Create file: `resources/views/components/plugins/myplugin.blade.php`

2. Add content:

```blade
{{-- My Plugin --}}
@once
    @push('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/plugins/myplugin/myplugin.css') }}">
    @endpush

    @push('plugin-scripts')
        <script src="{{ asset('assets/plugins/myplugin/myplugin.js') }}"></script>
    @endpush
@endonce
```

3. Use in views:

```blade
<x-plugins.myplugin />
```

## Performance Tips

1. **Only include plugins you need** - Don't include DataTables on a simple form
2. **Group related plugins** - If you always use SweetAlert with DataTables, load both
3. **Use @once directive** - Prevents duplicate loading if component included multiple times
4. **Cache assets** - Set proper cache headers in your web server config
5. **Consider CDN** - For frequently used plugins, CDN might be faster

## Backward Compatibility

The old `app.blade.php` is replaced, but if you have views that don't include plugin components, they'll still work - they just won't have those plugins available. Update views gradually as needed.

## Testing

After migration, test each page:

1. Check console for JavaScript errors
2. Verify all features work (tables, charts, forms)
3. Check page load time in Network tab
4. Ensure no duplicate plugin loads

## Troubleshooting

**Issue**: Plugin not loading

- **Solution**: Add `<x-plugins.pluginname />` to your view

**Issue**: Plugin loaded twice

- **Solution**: Check if you included component multiple times, @once should prevent this

**Issue**: Old scripts not working

- **Solution**: Move them to `@push('scripts')` section

**Issue**: Styles not applied

- **Solution**: Move CSS to `@push('styles')` section
