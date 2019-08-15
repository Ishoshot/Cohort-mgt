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
                <h1 class="font-weight-bold">Manage Tracks</h1>
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

    {{--  DISPLAYS ALL VALIDATION ERRORS  --}}
    <div class="col-sm-12">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-volume-up"></i>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>{{ $error }}
                </div>
            @endforeach
        @endif
    </div>


    {{-- BUTTON FOR MODAL POPUP --}}
    <div class="col-sm-12">
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
        {{ 'Add New' }} <i class="fa fa-plus"></i>
        </button>
    </div>

    {{-- <!-- Modal --> --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" style="color:#000;" id="exampleModalLabel">Add New Track</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="/track/create" class="needs-validation" novalidate method="POST">

                        @csrf

                        <div class="form-group">
                            <label for="title" class="col-form-label font-weight-bold">{{ __('Title') }}</label><br/>

                            <input id="title"
                            name="title" type="text"
                            class="form-control @error('title') is-invalid @enderror"
                            autofocus rows="5" required placeholder="~e.g Full Stack Web Development"/>

                            <div class="invalid-feedback">
                                Track field cannot be empty
                            </div>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="form-group">
                                <label for="track" class="col-form-label font-weight-bold">{{ __('Status') }}</label><br/>

                                <div class="d-inline">
                                    <input type="radio" id="active_track" class="form-radio" name="track_status"
                                    Value="1" checked> <label for="active_track">Active</label>
                                </div>

                                <div class="ml-5 d-inline">
                                    <input type="radio" id="inactive_track" class="form-radio" name="track_status"
                                    Value="0"> <label for="inactive_track">InActive</label>
                                </div>
                        </div>

                        <div class="modal-footer d-flex row pt-4 justify-content-between">
                            <div class="ml-3">
                                <button class="btn btn-primary">Create Track</button>
                            </div>
                            <div class="mr-3">
                                <button class="btn btn-danger" type="reset">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--  TABLE TO DISPLAY ALL RECORDS IN COHORTS TABLES  --}}
    <div class="col-md-12 mb-2 mt-3">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white"><i class ="fa fa-book"></i> Manage Tracks</h3>
            </div>

            <div class="card-body">

                {{-- Checks if the table is empty --}}
                @if(count($track) < 1)
                <div class="alert  alert-warning alert-dismissible fade show" role="alert">
                    <i class="fa fa-volume-up"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>Nothing Here Yet !, Add New Tracks
                </div>
                @else

                <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Created On</th>
                        <th scope="col" style="text-align:center;">Offered by</th>
                        <th scope="col" style="text-align:center;">No of Topics</th>
                        <th scope="col" style="text-align:center;">Status</th>
                        <th colspan="2" scope="col" style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($track as $tracks)
                <tr>

                    <td>
                        {{$tracks->title}}
                    </td>

                    <td>
                        {{ $tracks->created_at->format('l, M-Y @ H:i A') }}
                    </td>

                    <td class="text-center">
                        {{ $tracks->cohorts->count() }}
                    </td>

                    <td class="text-center">
                        {{ $tracks->topics->count() }}
                    </td>

                    <td class="text-center">
                        <form>
                            <input data-id="{{ $tracks->id }}"
                            class="toggle-class" type="checkbox"
                            data-onstyle="success" data-offstyle="danger"
                            data-toggle="toggle" data-on="Active"
                            data-off="InActive" {{ $tracks->status ? 'checked' : '' }}>
                        </form>
                    </td>
                    <td>
                        <button class="show-topics btn btn-outline-primary"
                        data-toggle="collapse" href="#collapseTopics"
                        aria-expanded="false" aria-controls="collapseTopics"
                        data-id="{{$tracks->id}}">
                        <i class="fa fa-eye"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <button class="deleteRecord  btn btn-outline-danger" id="del" data-id="{{ $tracks->id }}"><i class="fa fa-trash-o"></i></input>
                    </td>
                </tr>
                @endforeach
                </tbody>
                </table>

                @endif
                <hr>
            </div>

            <div class="col-12 d-flex justify-content-center">
                {{$track->links() }}
            </div>
        </div>

        {{--  This div holds the table that displays list of topics for a selected track  --}}
        <div class="collapse" id="collapseTopics">
            <div class="alert show-alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fa fa-volume-up"></i>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>There are no topics yet !!! Newly created topics will appear here.
            </div>

               <div class="card" id="content">
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Duration</th>
                            </tr>
                        </thead>
                        <tbody id="topic-data">
                            <tr>
                                <td>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>




    {{-- INLINE JS --}}
    <script>

            {{-- STATUS TOGGLER --}}
            $('.toggle-class').change(function() {
                    var status = $(this).prop('checked') == true ? 1 : 0;
                    var track_id = $(this).data('id');

                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: 'trackStatus',
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        data: {'status': status, 'track_id': track_id},
                        success: function(data){
                          console.log(data)
                        }
                    });
            });

        //AJAX DELETE REQUEST
        $(".deleteRecord").click(function()
        {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax(
            {
                url: "track/"+id,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },

                success: function (data)
                {
                    if (data.success)
                    {
                        setTimeout(function(){ location.reload(); }, 3000);

                    }
                }
            });
        });

        //Ajax Request To Show List of Topics for a Selected Tracks
        $( ".show-topics" ).click(function() {
            $("#topic-data").empty().slideDown( "slow" );
            var track_id= $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: 'showTopics',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                data: {'id': track_id},
                success: function(data)
                {
                    if(data.topics)
                    {
                    $('#content').show();
                      for(var i=0; i < data.topics.length; i++)
                      {
                        $("#topic-data").append( $("<tr>"));
                        $("#topic-data").append( $("<td/>").text(data.topics[i].title) );
                        $("#topic-data").append( $("<td/>").text(data.topics[i].duration + " days") );
                        $("#topic-data").append( $("</tr>"));

                        $('.show-alert').hide();

                        }

                      if(data.topics == '' )
                      {
                          $('#content').hide();
                          $('.show-alert').show('slow');
                      }
                    }
                }
            });
        });


</script>

</div> <!-- .content -->
</div><!-- /#right-panel -->

{{-- <!-- Right Panel --> --}}

@endsection
