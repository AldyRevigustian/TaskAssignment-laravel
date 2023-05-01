<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="/assets/css/main/app.css">
    <link rel="stylesheet" href="/assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="/assets/css/shared/iconly.css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css">
    <link rel="stylesheet" href="/assets/extensions/choices.js/public/assets/styles/choices.css" />

    <!-- Include Bootstrap CSS and JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Include Bootstrap datetimepicker CSS and JavaScript -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />

    <style>
        ::-webkit-scrollbar {
            width: 20px;
        }

        ::-webkit-scrollbar-track {
            background-color: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #d6dee1;
            border-radius: 20px;
            border: 6px solid transparent;
            background-clip: content-box;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #a8bbbf;
        }

        div.dataTable-top {
            padding: 5px 0;
        }

        input:read-only {
            background-color: #efefef;
            pointer-events: none;
        }

        .choices__inner {
            background-color: white
        }
    </style>

</head>

@php
    $identity = App\Models\Identity::first();
@endphp

<body class="theme-light">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header position-relative">
                <div class="d-flex ">
                    <div class="logo mx-auto">
                        @if ($identity->app_logo != null)
                            <img src="{{ $identity->app_logo }}" style="width: 150px; height: 150px;object-fit: contain" alt="Logo">
                        @else
                            <h3>
                                Task <br>
                                Assignment
                            </h3>
                        @endif
                    </div>
                    <div class="sidebar-toggler  x">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu mt-0">
                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item {{ request()->is('dashboard*') ? 'active' : '' }} ">
                        <a href="{{ route('dashboard') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->is('admin*') ? 'active' : '' }} ">
                        <a href="{{ route('admin') }}" class='sidebar-link'>
                            <i class="bi bi-person-fill"></i>
                            <span>Admin</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('employee*') ? 'active' : '' }} ">
                        <a href="{{ route('employee') }}" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Employee</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('task*') ? 'active' : '' }} ">
                        <a href="{{ route('task') }}" class='sidebar-link'>
                            <i class="bi bi-list-task"></i>
                            <span>Task</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('history*') ? 'active' : '' }} ">
                        <a href="{{ route('history') }}" class='sidebar-link'>
                            <i class="bi bi-clock-history"></i>
                            <span>History</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('identity*') ? 'active' : '' }} ">
                        <a href="{{ route('identity') }}" class='sidebar-link'>
                            <i class="bi bi-info-circle-fill"></i>
                            <span>Identity</span>
                        </a>
                    </li>
                    <li class="sidebar-item" style="margin-bottom:5rem;">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class='sidebar-link'>
                            <i class="bi bi-box-arrow-in-left"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </div>
    <div id="main" class='layout-navbar navbar-fixed'>
        <header>
            <nav class="navbar navbar-expand navbar-light navbar-top">
                <div class="container-fluid">
                    <a href="#" class="burger-btn d-block">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>


                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-lg-0">
                        </ul>
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                                <p class="mb-0 text-sm text-gray-600">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ Auth::user()->photo }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div id="main-content" class="pt-0" style="min-height: 80vh">
            @yield('content')
        </div>
    </div>


    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="/assets/js/bootstrap.js"></script>
    <script src="/assets/js/app.js"></script>
    <script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="/assets/js/pages/simple-datatables.js"></script>
    <script src="/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="/assets/js/pages/form-element-select.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script>
        const appBody = document.body;
        if (localStorage.getItem('theme') == 'theme-dark') {
            localStorage.setItem('theme', "theme-light")
            appBody.classList.add("theme-light");
        } else {
            localStorage.setItem('theme', "theme-light")
            appBody.classList.add("theme-light");
        };
    </script>
    @stack('scripts')
</body>

</html>
