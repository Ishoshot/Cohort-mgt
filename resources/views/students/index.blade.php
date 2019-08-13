
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
                <h5 class="modal-title font-weight-bold" style="color:#000;" id="exampleModalLabel">Add New Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body py-4">
                <form  action="/students/create" class="needs-validation" novalidate method="POST">
                    @csrf
                <div class="row">

                    <div class="form-group col-6">
                        <label for="firstname" class="col-form-label font-weight-bold">{{ __('Firstname') }}</label>
                        <input id="firstname"
                        name="firstname"
                        type="text"
                        placeholder="e.g John"
                        class="form-control @error('firstname') is-invalid @enderror"
                        required autofocus rows="5" />

                        <div class="invalid-feedback">
                            Please enter firstname
                        </div>

                        @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="lastname" class="col-form-label font-weight-bold">{{ __('Lastname') }}</label>
                        <input id="lastname"
                        name="lastname"
                        type="text"
                        placeholder="e.g Doe"
                        class="form-control @error('lastname') is-invalid @enderror"
                        autofocus required rows="5" />

                        <div class="invalid-feedback">
                            Please enter lastname
                        </div>

                        @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-6">
                        <label for="email" class="col-form-label font-weight-bold">{{ __('e-Mail') }}</label>
                        <input id="email"
                        name="email"
                        type="text"
                        placeholder="e.g johndoe@fofxacademy.com"
                        class="form-control @error('email') is-invalid @enderror"
                        autofocus required rows="5" />

                        <div class="invalid-feedback">
                            Please enter email
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="phone" class="col-form-label font-weight-bold">{{ __('Phone No.') }}</label>
                        <input id="phone"
                        name="phone"
                        type="text"
                        placeholder="+2348100003"
                        class="form-control @error('phone') is-invalid @enderror"
                        autofocus required rows="5" />

                        <div class="invalid-feedback">
                                Please enter phone number
                        </div>

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-6">
                            <label for="username" class="col-form-label font-weight-bold">{{ __('Username') }}</label>
                            <input id="username"
                            name="username"
                            type="text"
                            placeholder="e.g john.doe"
                            class="form-control @error('username') is-invalid @enderror"
                            autofocus required rows="5" />
                            <div class="invalid-feedback">
                                Please enter username
                            </div>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="cohort" class="col-form-label font-weight-bold">{{ __('Cohort') }}</label>
                        <select name="cohort" id="cohort"
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
                </div>
                <div class="row">
                    <div class="form-group col-6">
                            <label for="e-contact" class="col-form-label font-weight-bold">{{ __('Emergency Contact (Name)') }}</label>
                            <input id="e_contact"
                            name="e_contact"
                            type="text"
                            placeholder="e.g Mrs. Dora Doe"
                            class="form-control @error('e_contact') is-invalid @enderror"
                            autofocus required rows="5" />

                            <div class="invalid-feedback">
                             Emergency contact is required
                            </div>
                            @error('e_contact')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="form-group col-6">
                            <label for="e_phone" class="col-form-label font-weight-bold">{{ __('Emergency Contact (Phone)') }}</label>
                            <input id="e_phone"
                            name="e_phone"
                            type="text"
                            placeholder="e.g +234810000000"
                            class="form-control @error('e_phone') is-invalid @enderror"
                            autofocus required rows="5" />

                            <div class="invalid-feedback">
                                    Emergency phone number is required
                            </div>
                            @error('e_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </div>

                    <div class="modal-footer d-flex row pt-4 justify-content-between">
                        <div class="ml-3">
                            <button class="btn btn-primary">Add Student</button>
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
                <i class="fa fa-list"></i> {{ 'Manage Students  ' }}
            </h3>
        </div>

        <div class="card-body" id="content">
            @if(count($students) < 1)
                <div class="alert  alert-warning alert-dismissible fade show" role="alert">
                    <i class="fa fa-volume-up"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>There are no students yet !!! Newly added students will appear here.
                </div>
            @else
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Firstname</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Username</th>
                        <th scope="col">Cohort</th>
                        <th scope="col" style="text-align:center;">View</th>
                        <th scope="col" style="text-align:center;">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                      <tr>
                        <td>{{$student->firstname}}</td>
                        <td>{{$student->lastname}}</td>
                        <td>{{$student->username}}</td>
                        <td>{{ $student->cohort->name}}</td>

                        <td class="text-center">
                            <a class="btn btn-outline-primary" role="button" href="/students/{{ $student->id }}">
                                <i class="fa fa-eye"></i> View
                            </a>
                        </td>

                        <td class="text-center">
                            <button class="deleteRecord btn btn-outline-danger"
                                id="del" data-id="{{ $student->id }}"><i class="fa fa-trash-o"></i>
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
              {{$students->links() }}
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
                url: "students/"+id,
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
