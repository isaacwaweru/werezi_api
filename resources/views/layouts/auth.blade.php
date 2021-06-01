<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>

    <!-- begin::global styles -->
    <link rel="stylesheet" href="{{ asset('css/vendor.bundle.css') }}" type="text/css">
    <!-- end::global styles -->

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}" type="text/css">
    <!-- end::custom styles -->

</head>
<body class="bg-gray h-100-vh p-t-0">

@yield('content')

<!-- begin::global scripts -->
<script src="{{ asset('js/vendor.bundle.js') }}"></script>
<!-- end::global scripts -->

<!-- begin::custom scripts -->
{{-- <script src="{{ asset('js/custom.js') }}"></script> --}}
<script src="{{ asset('js/borderless.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<!-- end::custom scripts -->

</body>
</html>