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
                <h1 class="font-weight-bold"><i class="fa fa-users"></i> {{ $cohort->name }}</h1>
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
                        <a class="nav-link" id="pills-students-tab" data-toggle="pill" href="#students" role="tab" aria-controls="pills-students" aria-selected="false">Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-schedule-tab" data-toggle="pill" href="#schedule" role="tab" aria-controls="pills-schedule" aria-selected="false">Schedule</a>
                    </li>
                </ul>
            </div>

            <div class="card-body" id="content">

                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="col-md-12">
                            {{-- <h4 class="font-weight-bold mb-3">{{ $cohort->name }}</h4> --}}
                            <p>Track: {{ $cohort->track->title }}</p>
                            <p>Track status: {{ $cohort->status }}</p>
                            <p>Active from: {{ $cohort->start_date .' to '. $cohort->end_date }}</p>
                            <p>Number of Students: {{ count($cohort->students) }}</p>
                            <p>Duration: {{ $cohort->duration }}</p>
                            <p>Location: {{ $cohort->location }}</p>
                            <p>Created on: {{ $cohort->created_at->format('l, M-Y @ H:i A') }}</p>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="topics" role="tabpanel" aria-labelledby="pills-topics-tab">
                        @if(count($cohort->track->topics) < 1)
                            <div class="alert  alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa fa-volume-up"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>There are no topics yet !!! Add topics to the track offered by this cohort.
                            </div>
                        @else
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col" class="text-center">Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cohort->track->topics as $topic)
                                     <tr>
                                        <td>{{ $topic->title }}</td>
                                        <td class="text-center">{{ $topic->duration.' days' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>


                    <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="pills-students-tab">
                        @if(count($cohort->students) < 1)
                            <div class="alert  alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa fa-volume-up"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>There are no students yet !!! Newly added students will appear here.
                            </div>
                        @else
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">Fullname</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" class="text-center">Phone Number</th>
                                    <th scope="col" class="text-center">Date Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cohort->students as $student)
                                    <tr>
                                        <td>{{ $student->firstname .' '. $student->firstname }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td class="text-center">{{ $student->phone }}</td>
                                        <td class="text-center">
                                           {{ $student->created_at->format('l, M-Y @ H:i A') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>


                    <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="pills-schedule-tab">
                        @if(!$schedules->count())
                        <div class="col-md-12 p-0 mb-3">
                            <div class="float-right">
                               <form method="POST" action="/schedule/generate/{{$cohort->id}}">
                                @csrf
                                <button class="btn btn-primary">
                                    <i class="fa fa-download"></i> Generate
                                </button>
                               </form>
                            </div>
                        </div>
                        <div class="col-md-12 alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fa fa-volume-up"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>Oops! No Schedule found.</br> &nbsp; Please ensure that the topics for this track are intact and ordered. To proceed, click on the button below to generate.
                        </div>
                        @else
                        <table class="table table-hover">
                           
                            @if($schedules->count() < $cohort->track->topics->count())
                            <div class="col-md-12 alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa fa-volume-up"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                This Schedule is a commit behind.
                                <form method="POST" action="/schedule/re-generate/{{$cohort->id}}" class="d-inline">
                                    @csrf                        
                                    <button class="btn btn-secondary">
                                        <i class="fa fa-undo"></i> Re-generate
                                    </button>
                                </form>
                            </div>
                            @endif
                           
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col" class="text-center">Duration</th>
                                    <th scope="col" class="text-center">Start date</th>
                                    <th scope="col" class="text-center">Finish date</th>
                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($schedules as $schedule)

                                {{-- /topics/update/{{ $topic->id }} --}}
                                
                                <form action="" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <tr>

                                        <td>
                                            {{ $schedule->title }}
                                            <input type="hidden" name="title" value="{{ $schedule->title }}">
                                        </td>

                                        <td class="text-center">
                                            {{ $schedule->duration.' days' }}
                                            <input type="hidden" name="duration" value="{{ $schedule->duration }}">
                                        </td>

                                        <td class="text-center">
                                            <div class="input-group start-date date">
                                                <input id="start_date" type="text"
                                                name="start_date" value="{{ $schedule->start_date }}"
                                                class="form-control @error('start_date') is-invalid @enderror" autofocus
                                                autocomplete="off"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </div>
                                            </div>

                                            @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </td>

                                        <td class="text-center">
                                            <div class="input-group end-date date">
                                                <input id="end_date" type="text"
                                                name="end_date" value="{{ $schedule->end_date }}"
                                                class="form-control @error('end_date') is-invalid @enderror"
                                                autofocus autocomplete="off"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </div>
                                            </div>

                                            @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </td>

                                        <td>
                                            <button class="btn btn-primary">
                                                <i class="fa fa-save text-white"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </form>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- .content -->
</div><!-- /#right-panel -->
{{-- <!-- Right Panel --> --}}

<script>

    $('.input-group.start-date').datepicker({
        autoclose: true,
        daysOfWeekDisabled: [0, 6],
        todayHighlight: true,
        format: "yyyy-mm-dd"
    });

    $('.input-group.end-date').datepicker({
        autoclose: true,
        daysOfWeekDisabled: [0, 6],
        todayHighlight: true,
        format: "yyyy-mm-dd"
    });

    // $('#start_date').change(function() {
    //     var date = $(this).val();
    //     var ndate = new Date(date);
    //     var newdate = new Date(ndate);

    //     console.log(newdate);

    //     newdate.setDate(newdate.getDate() + 3);

    //     var dd = newdate.getDate();
    //     var mm = newdate.getMonth() + 1;
    //     var y = newdate.getFullYear();

    //     var someFormattedDate = dd + '-' + mm + '-' + y;

    //     console.log(someFormattedDate);

    //     document.getElementById('end_date').value = someFormattedDate;
    // });


</script>

@endsection
