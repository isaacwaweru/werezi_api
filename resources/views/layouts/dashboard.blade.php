<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ env('APP_NAME') }}</title>

    <!-- begin::global styles -->
    <link
        rel="stylesheet"
        href="{{ asset('css/vendor.bundle.css') }}"
        type="text/css"
    />
    <!-- end::global styles -->

    <!-- begin::custom styles -->
    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
        type="text/css"
    />
    <link
        rel="stylesheet"
        href="{{ asset('css/custom.css') }}"
        type="text/css"
    />
    <link
        rel="stylesheet"
        href="{{ asset('css/theme.css') }}"
        type="text/css"
    />
    <!-- end::custom styles -->
</head>
<body>

<!-- begin::side menu -->
<div class="side-menu">
    <div class="side-menu-body">
        <ul>
            <li class="side-menu-divider m-t-0"></li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="icon lni-dashboard"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}">
                    <i class="icon lni-menu"></i>Categories
                </a>
            </li>
            <li><a href="{{ route('admin.authors.index') }}"><i class="icon lni-pencil"></i>Authors</a></li>
            <li><a href="{{ route('admin.orders.index') }}"><i class="icon lni-package"></i>Orders</a></li>
            <li><a href="{{ route('admin.publishers.index') }}"><i class="icon lni-image"></i>Publishers</a></li>
            <li><a href="{{ route('admin.sellers.index') }}"><i class="icon lni-money-protection"></i>Sellers</a></li>
            <li><a href="{{ route('admin.books.index') }}"><i class="icon lni-book"></i>Books</a></li>
            <li class="has-dropdown">
                <a class="drop-toggle" href="#"><i class="icon lni-user"></i>Users</a>
                <ul class="navbar-dropdown">
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                        >System Users</a
                        >
                    </li>
                </ul>
            </li>
            <li class="side-menu-divider m-t-10">Website Elements</li>
            <li>
                <a href="{{ route('admin.home-page-slides.index') }}"
                ><i class="icon lni-image"></i>Home Page Slider</a
                >
            </li>
            <li>
                <a href="{{ route('admin.featured-items.index') }}"
                ><i class="icon lni-plus"></i> Featured Items</a
                >
            </li>
        </ul>
    </div>
</div>
<!-- end::side menu -->

<nav class="navbar bg-white">
    <div class="header-logo">
        <a href="/" class="text-logo">
            <img src="{{ asset('/logo.png') }}" class="w-50" alt="{{ env('APP_NAME') }} logo" height="50px">
        </a>
    </div>
    <a href="#" class="btn btn-outline-secondary ml-auto"
       onclick="$('#logout-form').submit()">Hi, {{ auth()->user()->name }}! Logout</a>
    <form action="{{ route('logout') }}" id="logout-form" method="post">
        {{ csrf_field() }}
    </form>
</nav>

<!-- begin::main content -->
<main class="main-content">
    <div class="container-fluid">
        @yield('content')
    </div>
</main>
<!-- end::main content -->

<!-- begin::global scripts -->
<script src="{{ asset('js/vendor.bundle.js') }}"></script>
<!-- end::global scripts -->

<!-- begin::custom scripts -->
{{-- <script src="{{ asset('js/custom.js') }}"></script> --}}
<script src="{{ asset('js/borderless.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<!-- end::custom scripts -->
<script> let domain = "{{ url('/') }}"</script>
@include('vendor.roksta.toastr')

@yield('scripts')
</body>
</html>

