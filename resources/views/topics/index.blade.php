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
                <h1 class="font-weight-bold">MANAGE TOPICS</h1>
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

<div class="row d-flex">
    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="col-md-6">
            <div class="alert  alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-volume-up"></i>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>{{ $error }}
            </div>
        </div>
        @endforeach
     @endif
</div>


<div class="col-sm-12">
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
    {{ 'Add New' }} <i class="fa fa-plus"></i>
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" style="color:#000;" id="exampleModalLabel">Add New Topic</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="/topics/create" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="title" class="col-form-label font-weight-bold">{{ __('Topic Title') }}</label>
                        <input id="title"
                        name="title"
                        type="text"
                        placeholder="e.g Introduction to Laravel" 
                        class="form-control @error('title') is-invalid @enderror"
                        autofocus rows="5" />

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="track" class="col-form-label font-weight-bold">{{ __('Track') }}</label>
                        <select name="track"
                        class="form-control @error('title') is-invalid @enderror">
                            <option value="">~ Please Select Track ~</option>
                            @foreach ($tracks as $track)
                                <option value="{{ $track->id }}">{{ $track->title }}</option>
                            @endforeach
                        </select>

                        @error('track')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="duration" class="col-form-label font-weight-bold">{{ __('Topic Duration') }}</label>
                        <select name="duration"
                        class="form-control @error('duration') is-invalid @enderror">
                            <option value="">~ Please Select Duration in Days ~</option>
                            @for ($i = 2; $i <= 10 ; $i++)
                                <option value="{{ $i }}">{{ $i." days" }}</option>
                            @endfor
                        </select>

                        @error('duration')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="modal-footer d-flex row pt-4 justify-content-between">
                        <div class="ml-3">
                            <button class="btn btn-primary">Add Topic</button>
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


{{--    --}}

<div class="col-md-12 mb-2 mt-3">
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="text-white">
                <i class="fa fa-list"></i> {{ 'Manage Topics' }}
            </h3>
        </div>

        <div class="card-body" id="content">
            @if(count($topics) < 1)
                <div class="alert  alert-warning alert-dismissible fade show" role="alert">
                    <i class="fa fa-volume-up"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>There are no topics yet !!! Newly created topics will appear here.
                </div>
            @else
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Track</th>
                        <th scope="col" style="text-align:center;">Duration</th>
                        <th scope="col" style="text-align:center;">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topics as $topic)
                      <tr>
                        <td>{{$topic->title}}</td>

                        <td>{{$topic->track->title}}</td>

                        <td class="text-center">{{$topic->duration." days"}}</td>

                        <td class="text-center">
                            <button class="deleteRecord btn btn-outline-danger" 
                                id="del" data-id="{{ $topic->id }}"><i class="fa fa-trash-o"></i>
                            </button>
                        </td>
                      </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            <hr/>    
        </div>

        <div class="col-12 d-flex justify-content-center">
              {{$topics->links() }}
        </div>
    </div>
</div>


<script type="text/javascript" charset="utf-8">
    
  {{-- DELETE REQUEST --}}
        $(".deleteRecord").click(function(){
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax(
            {
                url: "topics/"+id,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                
                success: function (data)
                {
                    if (data.success)
                    {
                        setInterval(function(){
                            $('div#content').load(location.href + ' #content');
                        }, 1000);
                    }
                }
            });
        });

</script>

</div> <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel -->

@endsection
