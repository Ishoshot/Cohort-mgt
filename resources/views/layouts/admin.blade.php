<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--  <!-- CSRF Token -->  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--  TITLE  --}}
    <title>fofxAcademy</title>

    {{--  <!-- Fonts -->  --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/icons/favicon.ico')}}"/>


       {{--  <!-- Scripts -->  --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-toggle.min.js') }}"></script>
    <!-- Droppable only -->

    {{--  <!-- Styles -->  --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

</head>
<body>
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>

                 <a class="mt-3 name navbar-brand"  href="{{ url('/home') }}">
                   {{ '( ) fofxAcademy' }}
                </a>

                 <p class="navbar-brand hidden">fofx</p>

            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="/home"> <i class="menu-icon fa fa-dashboard"></i>DASHBOARD </a>
                    </li>

                    <h3 class="menu-title">ACTIVITIES</h3><!-- /.menu-title -->

                    <li>
                        <a href="/track"> <i class="menu-icon fa fa-book"></i>Manage Tracks</a>
                    </li>

                    <li>
                        <a href="/topics"> <i class="menu-icon fa fa-list"></i>Manage Topics </a>
                    </li>

                    <li>
                        <a href="/cohorts"> <i class="menu-icon fa fa-users"></i>Manage Cohorts</a>
                    </li>

                    <li>
                        <a href="/students"> <i class="menu-icon fa fa-graduation-cap"></i>Manage Students</a>
                    </li>

                    <li>
                        <a href="/pair"><i class="menu-icon fa fa-male"></i>Manage Pairs </a>
                    </li>

                    <li>
                        <a href="/attendance"><i class="menu-icon fa fa-check"></i>Attendance </a>
                    </li>

                    <h3 class="menu-title">Extras</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-wrench"></i>Settings</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                   <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form-side" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div><!-- /.navbar-collapse -->

        </nav>

    </aside><!-- /#left-panel -->

    @yield('content')

</body>
</html>
