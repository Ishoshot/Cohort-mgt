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
                    <h1 class="font-weight-bold">Manage Pairs</h1>
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
    <div class="card">
        <div class="card-body">

        <div class="form-container d-flex justify-content-center text-center">
            <form action="/pair/fetch" class="needs-validation col-6" novalidate id="form1" method="GET">
                <div class="form-group">
                        <label for="cohort" class="col-form-label font-weight-bold">{{ __('Which Cohort Does The Students You Want To Pair Belong To?') }}</label>
                        <select name="cohort"
                        class="form-control @error('cohort') is-invalid @enderror" required>
                            <option value="">~ Please Select Cohort ~</option>
                            @foreach ($cohorts as $cohort)
                                <option value="{{ $cohort->id }}">{{ $cohort->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select a cohort
                        </div>
                        @error('cohort')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="mt-2">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
        </div>
    <div>


    {{--  MODAL ON PAGE LOAD  --}}
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                    </div>
                    <div class="col-6"

 {{--  <main>
                            @foreach ($students as $student)

                            <div class="wrapper">
                                <div class="box">
                                    {{ $student->firstname}}
                                </div>
                            </div>

                            @endforeach
                        </main>  --}}                    </div>
                </div>
            </div>
        </div>
    </div>
    </div> <!-- .content -->
    </div><!-- /#right-panel -->

    {{-- <!-- Right Panel --> --}}
<script>

</script>
@endsection
