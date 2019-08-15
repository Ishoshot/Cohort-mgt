
@extends('layouts.admin')

@section('content')

<!-- Right Panel -->

<div id="right-panel" class="right-panel">

<!-- Header-->
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

                <div class="dropdown for-message">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-email"></i>
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
    </div>

</header> <!-- /header -->
<!-- Header-->


<div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1 class="font-weight-bold">View Attendance</h1>
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

    <div class="col-sm-12 show-datepickerdiv">
        <button type="button" class="btn btn-primary pickdate float-right" data-toggle="modal" data-target="#exampleModal">
        {{ 'Pick Date' }} <i class="fa fa-calendar" aria-hidden="true"></i>
        </button>
    </div>

<div class="content mt-3">

    <div class="row align-items-center d-flext justify-content-center text-dark">
            <div class="col-sm-8 bg-dark datepickerdiv py-4">
            <form class="needs-validation pickdate" novalidate>
                <div class="form-group attendance">
                    <label for="tocheck" class="col-form-label font-weight-bold text-white">{{ __('Attendance for') }}</label><br/>

                    <div class="input-group date tocheck">
                        <input id="tocheck" type="text" name="created_at"
                        class="form-control @error('created_at') is-invalid @enderror" required autofocus/>
                        <div class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="invalid-feedback">
                        Please pick a start date
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-primary rounded-sm show-attendance">View Attendance</button>
                    </div>
                </div>
            </form>
            </div>
        </div>

    <div class="col-md-12 mb-2 mt-3 display-tendance">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">
                    <i class="fa fa-check"></i> {{ 'Check Attendance' }}
                </h3>
            </div>
            <div class="alert show-alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fa fa-volume-up"></i>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> No Attendance was for the selected date.
            </div>
            <div class="card-body" id="content">

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Student Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Student Pair</th>
                            <th scope="col">Topic</th>
                        </tr>
                    </thead>
                    <tbody id="today-tendance">
                            <tr>
                                <td>

                                </td>
                            </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>


    <script>

     //Ajax Request To Show List of Topics for a Selected Tracks
    $('.display-tendance').hide()
    $('.show-datepickerdiv').hide();

     $( ".show-attendance" ).click(function(e) {
        e.preventDefault();
        $('#today-tendance').empty();

        var created_at = $("[name='created_at").val();

        console.log(created_at);

        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'viewAttendance',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data: {'created_at': created_at},
            success: function(data)
            {
                if(data.attendance)
                {
                $('#content').show();
                    console.log(data.attendance);
                for(var i=0; i < data.attendance.length; i++)
                  {

                    $("#today-tendance").append( $("<tr>"));
                    $("#today-tendance").append( $("<td/>").text(data.attendance[i].fullname) );
                    $("#today-tendance").append( $("<td/>").text(data.attendance[i].username ) );
                    $("#today-tendance").append( $("<td/>").text(data.attendance[i].pair_fullname ) );
                    $("#today-tendance").append( $("<td/>").text(data.attendance[i].topic ) );
                    $("#today-tendance").append( $("</tr>"));
                  }
                    $('.datepickerdiv').hide('slow');
                    $('.display-tendance').show('slow');
                    $('.show-datepickerdiv').show();
                    $('.show-alert').hide();

                }
                if(data.attendance == '' )
                {
                    $('#content').hide();
                    $('.show-alert').show('slow');
                }
            }
        });
    });

    $( ".pickdate" ).click(function(e) {
        e.preventDefault();
        $('.datepickerdiv').show('slow');
    });

        $('.input-group.date.tocheck').datepicker({
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy-mm-dd",
        });

    </script>

    </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->

@endsection
