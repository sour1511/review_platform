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
                        <h1 class="m-0">{{ __('messages.custom_ads_list') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.custom_ads_list') }}</li>
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
                            @if (isset($data['customAds']) && count($data['customAds']) > 0)
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.ads_banner_image_en') }}</th>
                                        <th>{{ __('messages.heading_en') }}</th>
                                        <th>{{ __('messages.subheading_en') }}</th>
                                        <th>{{ __('messages.ads_banner_image_es') }}</th>
                                        <th>{{ __('messages.heading_es') }}</th>
                                        <th>{{ __('messages.subheading_es') }}</th>
                                        <th style="width: 150px !important;">{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['customAds'] as $adData)
                                        <tr>
                                            <td>
                                                @if ($adData->banner_img != null)
                                                    <img class="" src="{{ asset($adData->banner_img) }}"
                                                        width="150" height="50" alt="profile image" />
                                                @else
                                                    {{ __('messages.image_ad_not_found') }}
                                                @endif
                                            </td>
                                            <td>{{ $adData->heading }}</td>
                                            <td>{{ $adData->sub_heading }}</td>
                                            <td>
                                                @if ($adData->sp_banner_img != null)
                                                    <img class="" src="{{ asset($adData->sp_banner_img) }}"
                                                        width="150" height="50" alt="profile image" />
                                                @else
                                                    {{ __('messages.image_ad_not_found') }}
                                                @endif
                                            </td>
                                            <td>{{ $adData->sp_heading }}</td>
                                            <td>{{ $adData->sp_sub_heading }}</td>
                                            <td>
                                                <div class="col-xs- col-sm-12 col-md-12 col-lg-">
                                                    <div class="row">
                                                        <div class="col-xs- col-sm-3 col-md-3 col-lg-">
                                                            <button type="button" class="btn btn-primary btn-xs m-1"
                                                                onclick="editAdViewLoad('{{ $adData->id }}')"
                                                                title="Update Ad" style="">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            {{-- <a class="btn btn-primary btn-xs m-1" title="Update Ad"
                                                                href="{{ Route('useredit', ['id' => $adData->id]) }}"> </a> --}}
                                                        </div>
                                                        <div class="col-xs- col-sm-3 col-md-3 col-lg-">
                                                            <button type="button" class="btn btn-danger btn-xs scrap m-1"
                                                                data-id="<?php echo $adData->id; ?>" data-toggle="modal"
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
                                    <h4>{{ __('messages.Ads_not_found') }}</h4>
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

            <form role="form" method='post' action="{{ Route('deletead') }}"
                class="col-xs- col-sm-12 col-md-12 col-lg-">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">{{ __('messages.delete_ads') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type='hidden' id="deleteId" name='deleteId' value="">

                        <p>{{ __('messages.remove_ads') }}</p>
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

    {{-- edit ads --}}
    <div class="modal fade" id="adsEditModal" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">{{ __('messages.update_custom_ads') }}</h4>
                    <div class="login-form">
                        <form id="updateAdsForm" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('messages.ads_banner_image_en') }}</label>
                                        <div class="custom-file">
                                            <input class="custom-file-input" name="banner_img" id="banner_img"
                                                type="file" accept="image/*" onchange="validateProfilePic(this)">
                                            <label class="custom-file-label" for="banner_img"
                                                aria-describedby="inputGroupFileAddon02">{{ __('messages.select_banner_image') }}</label>
                                        </div>
                                    </div>
                                    <span class="text-warning float-right"
                                        style="font-size: 12px;">{{ __('messages.banner_size') }}</span>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">

                                    <div class="form-group">
                                        <label>{{ __('messages.main_heading_en') }}</label>
                                        <div class="input-with-gray">
                                            <input type="text" placeholder="Main Heading"
                                                class="form-control first_name" id="heading" maxlength="150"
                                                name="heading" required>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text heading_error"></span>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('messages.main_subheading_en') }}</label>
                                        <div class="input-with-gray">
                                            <input type="text" placeholder="Sub-heading"
                                                class="form-control last_name" id="sub_heading" maxlength="200"
                                                name="sub_heading">
                                        </div>
                                    </div>
                                    <span class="text-danger error-text sub_error"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('messages.ads_banner_image_es') }}</label>
                                        <div class="custom-file">
                                            <input class="custom-file-input" name="sp_banner_img" id="sp_banner_img"
                                                type="file" accept="image/*" onchange="validateProfilePicSp(this)">
                                            <label class="custom-file-label" for="sp_banner_img"
                                                aria-describedby="inputGroupFileAddon02">{{ __('messages.select_banner_image') }}</label>
                                        </div>
                                    </div>
                                    <span class="text-warning float-right"
                                        style="font-size: 12px;">{{ __('messages.banner_size') }}</span>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">

                                    <div class="form-group">
                                        <label>{{ __('messages.main_heading_es') }}</label>
                                        <div class="input-with-gray">
                                            <input type="text" placeholder="Main Heading"
                                                class="form-control first_name" id="sp_heading" maxlength="150"
                                                name="sp_heading" required>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text sp_heading_error"></span>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('messages.main_subheading_es') }}</label>
                                        <div class="input-with-gray">
                                            <input type="text" placeholder="Sub-heading"
                                                class="form-control last_name" id="sp_sub_heading" maxlength="200"
                                                name="sp_sub_heading">
                                        </div>
                                    </div>
                                    <span class="text-danger error-text sp_sub_error"></span>
                                </div>
                            </div>
                            <input type="hidden" name="ad_id" id="ad_id">
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
    {{-- end edit ads --}}
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
                url: "{{ Route('getadview') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    'ad_id': id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    // console.log(response);
                    if (response.status == 0) {

                    } else {
                        // type selection option
                        $('#updateAdsForm').get(0).reset();
                        $('#heading').val(response.data.adsData.heading);
                        $('#sub_heading').val(response.data.adsData.sub_heading);
                        $('#sp_heading').val(response.data.adsData.sp_heading);
                        $('#sp_sub_heading').val(response.data.adsData.sp_sub_heading);
                        $('#ad_id').val(id);
                        $('#adsEditModal').modal('show');
                    }
                }
            });
        }

        $('#updateAdsForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ Route('updatead') }}",
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
