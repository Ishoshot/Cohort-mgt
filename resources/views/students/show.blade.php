@extends('layouts.admin')

@section('content')

{{-- <!-- Right Panel --> --}}

<div id="right-panel" class="right-panel">

{{-- <!-- Header--> --}}
<header id="header" class="header">

    <div class="header-menu">

        <div class="col-sm-7">
            <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
            <div class="header-left">
                <button class="search-trigger"><i class="fa fa-search"></i></button>
                <div class="form-inline">
                    <form class="search-form">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                        <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                    </form>
                </div>

                <div class="dropdown for-notification">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                    </button>
                </div>
            </div>
        </div>

    <div class="col-sm-5">
            <div class="user-area dropdown float-right">
                <a class="dropdown-item nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>


</header> {{-- <!-- /header --> --}}
{{-- <!-- Header--> --}}


{{-- BREADCRUM FOR DATE & TIME DISPLAY --}}
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1 class="font-weight-bold">Manage Students</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class="active">
                    {{ $date.". " }} {{ $time }}
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">

    {{--  TABLE TO DISPLAY ALL RECORDS IN COHORTS TABLES  --}}
    <div class="col-md-12 mb-2 mt-3">
        <div class="card">

            <div class="card-header bg-light">
                <h2 class="text-dark"><i class="fa fa-info-circle"></i> Details</h2>
            </div>

            <div class="card-body" id="content">
                <div class="col-md-12">
                    <h4 class="font-weight-bold mb-2">{{ $student->firstname }} {{ $student->lastname }}</h4>
                    <p>Username: {{ $student->username }}</p>
                    <p>E-mail: {{ $student->email }}</p>
                    <p>Phone No: {{ $student->phone }}</p>
                    <p>Cohort: {{ $student->cohort->name }}</p>
                    <p>Emergency Contact: {{ $student->e_contact }}</p>
                    <p>Emegergency Phone: {{ $student->e_phone }}</p>
                </div>
            </div>
        </div>
    </div>

</div> <!-- .content -->
</div><!-- /#right-panel -->
{{-- <!-- Right Panel --> --}}

@endsection
