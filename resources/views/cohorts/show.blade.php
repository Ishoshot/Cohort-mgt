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
                <h1 class="font-weight-bold">Manage Cohorts</h1>
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
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#home" role="tab" aria-controls="pills-home" aria-selected="true">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-topics-tab" data-toggle="pill" href="#topics" role="tab" aria-controls="pills-topics" aria-selected="false">Topics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-schedule-tab" data-toggle="pill" href="#schedule" role="tab" aria-controls="pills-schedule" aria-selected="false">Schedule</a>
                    </li>
                </ul>
            </div>

            <div class="card-body" id="content">

                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="col-md-12 text-center">
                            <h4 class="font-weight-bold">{{ $cohort->name }}</h4>
                            <p>Track: {{ $cohort->track->title }}</p>
                            <p>Track status: {{ $cohort->status }}</p>
                            <p>Active from: {{ $cohort->start_date .' to '. $cohort->end_date }}</p>
                            <p>Duration: {{ $cohort->duration }}</p>
                            <p>Location: {{ $cohort->location }}</p>
                            <p>Created on: {{ $cohort->created_at->format('l, M-F-Y @ H:i A') }}</p>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="topics" role="tabpanel" aria-labelledby="pills-topics-tab">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr align="center">
                                    <th scope="col">Title</th>
                                    <th scope="col">Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cohort->track->topics as $topic)
                                    <tr>
                                        <td>{{ $topic->title }}</td>
                                        <td>{{ $topic->duration }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="pills-schedule-tab">...</div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- .content -->
</div><!-- /#right-panel -->
{{-- <!-- Right Panel --> --}}

@endsection
