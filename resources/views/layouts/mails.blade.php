<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} .::. Online Shopping</title>

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="{{ asset('css/mails.css') }}" type="text/css">
    <!-- end::custom styles -->

</head>
<body>
    
@yield('content')

<!-- begin::custom scripts -->
<script src="{{ asset('js/mails.js') }}"></script>
<!-- end::custom scripts -->

</body>
</html>