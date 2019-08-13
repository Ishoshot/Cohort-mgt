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

        <div class="container-fluid">
            <div class="row">
                <div class="col-6 bg-dark">

                    <hr>
                    <form class="needs-validation" novalidate id="form1">
                        <div class="form-group topic">
                            <label for="topic" class="col-form-label text-white font-weight-bold">{{ __('Pair for topic') }}</label>
                                <select name="topic"
                                    class="form-control @error('topic') is-invalid @enderror" required>
                                    <option value="">~ Please Select Topic ~</option>
                                    @foreach ($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->title }}</option>
                                    @endforeach
                                </select>
                            <div class="invalid-feedback">
                                Please select a topic
                            </div>
                        </div>

                        <div class="wrapper-drop mb-2 mt-5 studentI"  ondrop="drop(event)" ondragover="allowDrop(event)">

                        </div>

                        <div class="wrapper-drop studentII"  ondrop="drop(event)" ondragover="allowDrop(event)">

                        </div>

                   <div class="form-group text-center mt-3">
                     <button type="submit" class="btn btn-primary btn-lg btn-pair">Pair</button>
                   </div>

                    </form>
                </div>

                <div class="col-6">
                    <main>
                        @foreach ($students as $student)
                        <div class="wrapper mb-1" ondrop="drop(event)" ondragover="allowDrop(event)">
                            <input type="button" name="student_id"
                            class="box btn  btn-primary" id="{{ $student->username}}"
                            data-id="{{$student->cohort_id}}" draggable="true" ondragstart="drag(event)"
                            value="{{ $student->firstname}} {{ $student->lastname}}">
                        </div>
                        @endforeach
                    </main>
                </div>
            </div>
        </div>
    </div>
    </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <script>

    $(".btn-pair").click(function(e){

        e.preventDefault();

        //GET INPUT BOX FOR STUDENT ONE AND RETREIVE ALL DATA IN THEM
        var student_one = $('.studentI').find('input');
        //GET STUDENT ONE FullNAME
        var pairone_name = ($(student_one).attr('value'));
        //GET STUDENT TWO USERNAME
        var pairone_username = ($(student_one).attr('id'));

        //GET INPUT BOX FOR STUDENT TWO AND RETREIVE ALL DATA IN THEM
        var student_two = $('.studentII').find('input');
        //GET STUDENT TWO FullNAME
        var pairtwo_name = ((student_two).attr('value'));
        //GET STUDENT TWO USERNAME
        var pairtwo_username = ((student_two).attr('id'));

        //STUDENTs COHORT
        var cohort  = ((student_one).attr('data-id'));



        //Topic info
        var topic = $('select[name="topic"] option:selected').val();

        console.log(pairone_name);
        console.log(pairtwo_name);
        console.log(topic);
        console.log(cohort);
        console.log(pairtwo_username);
        console.log(pairone_username);

        $.ajax(
            {
                type: "POST",
                dataType: "json",
                url: '/mappairs',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },

                data: {
                'student_one': pairone_username ,
                'student_two': pairtwo_username,
                'student_one_fname': pairone_name,
                'student_two_fname': pairtwo_name,
                'cohort_id': cohort,
                'topic_id': topic},

                success: function (data)
                {
                    if (data.success)
                    {
                        console.log(data);
                    }
                }
            });

    });



</script>
@endsection
