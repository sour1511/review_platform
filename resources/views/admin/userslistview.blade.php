@extends('layout')
@section('head')
    @parent
@endsection
@section('content')
    @parent
    <div class="content-wrapper mb-3">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('messages.users') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.users') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

        </section>
        <!-- /.content-header -->
        {{-- show list of users --}}
        <div class="card m-3">
            <div class="card-header">
                {{-- <h3 class="card-title">Projects Detail</h3> --}}

                {{-- <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div> --}}
            </div>
            <div class="card-body">
                <div class="row">
                    @if (Session::has('error'))
                        <?php $errors = Session::get('error'); ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                        <table id="usersList" class="table table-bordered table-striped">
                            @if (isset($data['users']) && count($data['users']) > 0)
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.users_images') }}</th>
                                        <th>{{ __('messages.users_name') }}</th>
                                        <th>{{ __('messages.nickname') }}</th>
                                        <th>{{ __('messages.dob') }}</th>
                                        <th>{{ __('messages.gender') }}</th>
                                        <th>{{ __('messages.email') }}</th>
                                        <th style="width: 150px !important;">{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['users'] as $user)
                                        <tr>
                                            <td>
                                                @if ($user->user_pic != null)
                                                    <img class="img-circle img-bordered-sm"
                                                        src="{{ asset($user->user_pic) }}" width="50" height="50"
                                                        alt="profile image" />
                                                @else
                                                    <img class="img-circle img-bordered-sm"
                                                        src="{{ asset('frontend/assets/img/avatar.jpg') }}" width="50"
                                                        height="50" alt="profile image" />
                                                @endif
                                            </td>
                                            <td>{{ $user->name }} {{ $user->lname }}</td>
                                            <td>{{ $user->nickname }}</td>
                                            <td>{{ $user->dob }}</td>
                                            <td>{{ $user->gender }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <div class="col-xs- col-sm-12 col-md-12 col-lg-">
                                                    <div class="row">
                                                        <div class="col-xs- col-sm-3 col-md-3 col-lg-">
                                                            <a class="btn btn-primary btn-xs m-1" title="Update User"
                                                                href="{{ Route('useredit', ['id' => $user->id]) }}"><i
                                                                    class="fa fa-edit"></i> </a>
                                                        </div>
                                                        <div class="col-xs- col-sm-3 col-md-3 col-lg-">
                                                            <button type="button" class="btn btn-danger btn-xs scrap m-1"
                                                                data-id="<?php echo $user->id; ?>" data-toggle="modal"
                                                                data-target="#userDelete" data-toggle="modal"
                                                                title="{{ __('messages.delete') }}" style=""><i
                                                                    class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <div class="col-lg-12 col-xl-12 mb-3 text-center">
                                    <h4>{{ __('messages.users_not_found') }}</h4>
                                </div>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        {{-- end reviews --}}
    </div>

    <!-- delete pop up box -->
    <div class="modal fade" id="userDelete" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <form role="form" method='post' action="{{ Route('deleteuser') }}"
                class="col-xs- col-sm-12 col-md-12 col-lg-">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">{{ __('messages.delete_user') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type='hidden' id="deleteId" name='deleteId' value="">

                        <p>{{ __('messages.remove_user_msg') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">{{ __('messages.delete') }}</button>
                        <button type="button" class="btn btn-primary"
                            data-dismiss="modal">{{ __('messages.close') }}</button>
                    </div>
                    @csrf
                </div>
            </form>

        </div>
    </div>
    <!-- /.modal -->

@endsection
@section('script')
    @parent
    <script>
        $(document).on('click', '.scrap', function(e) {
            scrapId = $(this).attr('data-id');
            $('#deleteId').val(scrapId);
        });
        $(document).ready(function() {
            $(function() {
                $("#usersList").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "searching": true,
                    "autoWidth": true,
                    "deferRender": true,
                    "destroy": true,
                    "buttons": ["csv", "excel", "pdf"]
                }).buttons().container().appendTo('#usersListt_wrapper .col-md-6:eq(0)');
            });
        });
    </script>
@endsection
