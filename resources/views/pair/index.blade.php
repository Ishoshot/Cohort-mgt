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
    {{-- LINK TO MAPPING PAIR --}}
    <div class="col-sm-12">
        <a type="button" href="/pairing" class="btn btn-primary float-right">
        {{ 'Map Pair' }} <i class="fa fa-plus"></i>
        </a>
    </div>


    {{--  TABLE TO DISPLAY ALL RECORDS IN COHORTS TABLES  --}}
    <div class="col-md-12 mb-2 mt-3">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white"><i class ="fa fa-male"></i><i class ="fa fa-female"></i> Manage Pairs </h3>
                </div>

                <div class="card-body" id="content">

                    {{-- Checks if the table is empty --}}
                    @if(count($pairs) < 1)
                    <div class="alert  alert-warning alert-dismissible fade show" role="alert">
                        <i class="fa fa-volume-up"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ 'Oops! There are currently no pairs available, Click on the button above to pair new students' }}
                    </div>
                    @else

                    <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Pair Cohort</th>
                            <th scope="col">Student One</th>
                            <th scope="col">Student Two</th>
                            <th scope="col">Pair Topic</th>
                            <th scope="col" colspan="2" style="text-align:center;">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($pairs as $pair)
                    <tr>

                        <td>{{ $pair->cohort_name }}</td>

                        <td>{{ $pair->student_one_fname }}</td>

                        <td>{{ $pair->student_two_fname }}</td>

                        <td>
                            {{ $pair->topic_title}}
                        </td>

                        <td class="text-center">
                            <button class="deleteRecord  btn btn-outline-danger" id="del" data-id="{{ $pair->id }}"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>

                    @endif
                    <hr>
                </div>

                <div class="col-12 d-flex justify-content-center">
                    {{ $pairs->links() }}
                </div>

            </div>
            </div>

        </div>
</div> <!-- .content -->
</div><!-- /#right-panel -->

    {{-- <!-- Right Panel --> --}}
<script>
 //DELETE REQUEST
 $(".deleteRecord").click(function(){
    var id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");

    $.ajax(
    {
        url: "pair/"+id,
        type: 'DELETE',
        data: {
            "id": id,
            "_token": token,
        },

        success: function (data)
        {
            if (data.success)
            {
                window.location.reload(true);
            }
        }
    });

});
</script>
@endsection
