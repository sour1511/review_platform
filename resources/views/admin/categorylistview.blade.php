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
                        <h1 class="m-0">{{ __('messages.category_list') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.category_list') }}</li>
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
                            @if (isset($data['categories']) && count($data['categories']) > 0)
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.category_en') }}</th>
                                        <th>{{ __('messages.category_es') }}</th>
                                        <th style="width: 150px !important;">{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['categories'] as $category)
                                        <tr>
                                            <td>
                                                {{ $category->category_title }}
                                            </td>
                                            <td>{{ $category->es_category_title }}</td>
                                            <td>
                                                <div class="col-xs- col-sm-12 col-md-12 col-lg-">
                                                    <div class="row">
                                                        <div class="col-xs- col-sm-3 col-md-3 col-lg-">
                                                            <button type="button" class="btn btn-primary btn-xs m-1"
                                                                onclick="editAdViewLoad('{{ $category->id }}')"
                                                                style="">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-xs- col-sm-3 col-md-3 col-lg-">
                                                            <button type="button" class="btn btn-danger btn-xs scrap m-1"
                                                                data-id="<?php echo $category->id; ?>" data-toggle="modal"
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
                                    <h4>{{ __('messages.category_not_found') }}</h4>
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

    <!-- delete pop up box category -->
    <div class="modal fade" id="userDelete" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <form role="form" method='post' action="{{ Route('delete_category') }}"
                class="col-xs- col-sm-12 col-md-12 col-lg-">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">{{ __('messages.delete_category') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type='hidden' id="deleteId" name='deleteId' value="">

                        <p>{{ __('messages.remove_category') }}</p>
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

    {{-- edit category --}}
    <div class="modal fade" id="adsEditModal" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">{{ __('messages.update_category') }}</h4>
                    <div class="login-form">
                        <form id="updateAdsForm" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12">

                                    <div class="form-group">
                                        <label>{{ __('messages.category_en') }}</label>
                                        <div class="input-with-gray">
                                            <input type="text" placeholder="{{ __('messages.category_en') }}"
                                                class="form-control first_name" id="heading" maxlength="150"
                                                name="category_title" required>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text heading_error"></span>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('messages.category_es') }}</label>
                                        <div class="input-with-gray">
                                            <input type="text" placeholder="{{ __('messages.category_es') }}"
                                                class="form-control last_name" id="sub_heading" maxlength="200"
                                                name="es_category_title" required>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text sub_error"></span>
                                </div>
                            </div>

                            <input type="hidden" name="cat_id" id="ad_id">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" id="addAds"
                                            class="btn btn-success btn-md float-right">{{ __('messages.Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end edit category --}}
@endsection
@section('script')
    @parent
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>      
        $('#banner_img').on('change', function() {
            var fileName = $(this).val().replace('C:\\fakepath\\', " ");
            $(this).next('.custom-file-label').html(fileName);
        });

        $('#banner_img').focusout(function() {
            if (document.getElementById("banner_img").files.length == 0) {
                $(this).next('.custom-file-label').text('Select Banner Image');
            }
        });

        $('#banner_img').on('change', function() {
            if (document.getElementById("banner_img").files.length == 0) {
                $(this).next('.custom-file-label').text('Select Banner Image');
            }
        });

        var _URL = window.URL || window.webkitURL;

        function validateProfilePic(file) {
            var re = /(\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert('File must be in png,bmp,jpg,jpeg');
                $('#banner_img').val('');
                $('#banner_img').text('Select Banner Image');

            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert('File size cannot exceed 2 MB.');

                $('#banner_img').text('Select Banner Image');
                // $(".uploadResumeFiles_error").html("File size cannot exceed 2 MB.");
            }
            var files, img;
            if ((files = file.files[0])) {
                img = new Image();
                var objectUrl = _URL.createObjectURL(files);
                img.onload = function() {
                    var height = this.height;
                    var width = this.width;

                    if (height > 280) {
                        alert("Height must not exceed 280px.");
                        $('#banner_img').val('');
                        $('#banner_img').text('Select Banner Image');
                        return false;
                    }
                    _URL.revokeObjectURL(objectUrl);
                };
                img.src = objectUrl;
            }

        }

        var _URLSP = window.URL || window.webkitURL;

        $('#sp_banner_img').on('change', function() {
            var fileName = $(this).val().replace('C:\\fakepath\\', " ");
            $(this).next('.custom-file-label').html(fileName);
        });

        $('#sp_banner_img').focusout(function() {
            if (document.getElementById("sp_banner_img").files.length == 0) {
                $(this).next('.custom-file-label').text('Select Banner Image');
            }
        });

        $('#sp_banner_img').on('change', function() {
            if (document.getElementById("sp_banner_img").files.length == 0) {
                $(this).next('.custom-file-label').text('Select Banner Image');
            }
        });

        function validateProfilePicSp(file) {
            var re = /(\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert('File must be in png,bmp,jpg,jpeg');
                $('#sp_banner_img').val('');
                $('#sp_banner_img').text('Select Banner Image');

            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert('File size cannot exceed 2 MB.');
                $('#sp_banner_img').text('Select Banner Image');
                // $(".uploadResumeFiles_error").html("File size cannot exceed 2 MB.");
            }
            var filessp, imgSp;
            if ((filessp = file.files[0])) {
                imgSp = new Image();
                var objectUrlSp = _URL.createObjectURL(filessp);
                imgSp.onload = function() {
                    var heightSp = this.height;
                    var widthSp = this.width;

                    if (heightSp > 280) {
                        alert("Height must not exceed 280px.");
                        $('#sp_banner_img').val('');
                        $('#sp_banner_img').text('Select Banner Image');
                        return false;
                    }
                    _URLSP.revokeObjectURL(objectUrlSp);
                };
                imgSp.src = objectUrlSp;
            }
        }

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

        function editAdViewLoad(id) {
            $.ajax({
                url: "{{ Route('getcategoryview') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    'cat_id': id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    // console.log(response);
                    if (response.status == 0) {

                    } else {
                        // type selection option
                        $('#updateAdsForm').get(0).reset();
                        $('#heading').val(response.data.catData.category_title);
                        $('#sub_heading').val(response.data.catData.es_category_title);
                        $('#ad_id').val(id);
                        $('#adsEditModal').modal('show');
                    }
                }
            });
        }

        $('#updateAdsForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ Route('updatecategory') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {

                },
                success: function(data) {
                    if (data.status == 0) {

                    } else {
                        $('#updateAdsForm').get(0).reset();
                        $('#adsEditModal').modal('hide');
                        swal({
                            title: data.msg,
                            text: "",
                            type: "success",
                            icon: "success",
                            // timer: 2000,
                            showConfirmButton: true
                        }).then(function() {
                            location.reload();
                        });
                    }
                }
            });
        });
    </script>
@endsection
