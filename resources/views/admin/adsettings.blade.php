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
                        <h1 class="m-0">{{ __('messages.ads_settings') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.ads_settings') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

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

            <div class="card m-3">
                <div class="card-header">
                    <h3 class="card-title">{{ __('messages.show_ads_on_all') }}</h3>
                </div>
                <div class="card-body">
                    <form id="ad_hide" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label for="">{{ __('messages.show_custom_ads') }}</label>
                            </div>
                            @php
                                if (isset($data['showAds']) && $data['showAds']->count() > 0) {
                                    if ($data['showAds']->is_hide == 0) {
                                        $is_show_ads = 'checked=true';
                                    } else {
                                        $is_show_ads = '';
                                    }
                                }
                                
                                // var_dump($data['showAds']->is_hide);
                                
                            @endphp
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <input type="checkbox" name="is_hide" onclick='isHideAdsClick(this);' id="is_hide"
                                    style="height: 20px; width: 20px;margin-right: 10px;" {{ $is_show_ads }}>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card m-3">
                <div class="card-header">
                    <h3 class="card-title">{{ __('messages.Add_new_custom_ads') }}</h3>
                </div>
                <div class="card-body">

                    <form id="addAdsForm" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('messages.ads_banner_image_en') }}</label>
                                    <div class="custom-file">
                                        <input class="custom-file-input" name="banner_img" id="banner_img" type="file"
                                            accept="image/*" onchange="validateProfilePic(this)" required>
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
                                        <input type="text" placeholder="Main Heading" class="form-control first_name"
                                            id="heading" maxlength="150" name="heading" required>
                                    </div>
                                </div>
                                <span class="text-danger error-text heading_error"></span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('messages.main_subheading_en') }}</label>
                                    <div class="input-with-gray">
                                        <input type="text" placeholder="Sub-heading" class="form-control last_name"
                                            id="sub_heading" maxlength="200" name="sub_heading">
                                    </div>
                                </div>
                                <span class="text-danger error-text sub_error"></span>
                            </div>
                        </div>

                        {{-- spanish --}}

                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('messages.ads_banner_image_es') }}</label>
                                    <div class="custom-file">
                                        <input class="custom-file-input" name="sp_banner_img" id="sp_banner_img"
                                            type="file" accept="image/*" onchange="validateProfilePicSp(this)" required>
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
                                        <input type="text" placeholder="Main Heading" class="form-control first_name"
                                            id="sp_heading" maxlength="150" name="sp_heading" required>
                                    </div>
                                </div>
                                <span class="text-danger error-text sp_heading_error"></span>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('messages.main_subheading_es') }}</label>
                                    <div class="input-with-gray">
                                        <input type="text" placeholder="Sub-heading" class="form-control last_name"
                                            id="sp_sub_heading" maxlength="200" name="sp_sub_heading">
                                    </div>
                                </div>
                                <span class="text-danger error-text sp_sub_error"></span>
                            </div>

                        </div>

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
                <!-- /.card-body -->
            </div>
        </section>

    </div>
@endsection
@section('script')
    @parent
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function isHideAdsClick(cb) {
            // alert("Clicked, new value = " + cb.checked);
            var isHide = "";
            if (cb.checked == true) {
                isHide = 0;
            } else {
                isHide = 1;
            }

            $.ajax({
                url: "{{ Route('hide_ads') }}",
                data: {
                    'is_hide': isHide,
                },
                success: function(response) {
                    if (response.status == 0) {

                    } else {
                        swal({
                            title: response.msg,
                            text: "",
                            type: "success",
                            icon: "success",
                            // timer: 2000,
                            showConfirmButton: true
                        }).then(function() {
                            // loadTutorList();
                            location.reload();
                        });
                    }
                }
            });


        }

        $('#banner_img').on('change', function() {
            var fileName = $(this).val().replace('C:\\fakepath\\', " ");
            $(this).next('.custom-file-label').html(fileName);
        });

        $('#banner_img').focusout(function() {
            if (document.getElementById("banner_img").files.length == 0) {
                // $(".custom-file-label").text("{{ __('messages.select_banner_image') }}");
                $(this).next('.custom-file-label').text("{{ __('messages.select_banner_image') }}");
            }
        });

        $('#banner_img').on('change', function() {
            if (document.getElementById("banner_img").files.length == 0) {
                // $(".custom-file-label").text("{{ __('messages.select_banner_image') }}");
                $(this).next('.custom-file-label').text("{{ __('messages.select_banner_image') }}");
            }
        });

        var _URL = window.URL || window.webkitURL;

        function validateProfilePic(file) {
            var re = /(\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert("{{ __('messages.valid_profile_pic') }}");
                $('#banner_img').val('');
                $('#banner_img').text("{{ __('messages.select_banner_image') }}");

            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert("{{ __('messages.file_size_desc') }}");
                $('#banner_img').text("{{ __('messages.select_banner_image') }}");
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
                        $('#banner_img').text("{{ __('messages.select_banner_image') }}");
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
                // $(".custom-file-label").text("{{ __('messages.select_banner_image') }}");
                $(this).next('.custom-file-label').text("{{ __('messages.select_banner_image') }}");
            }
        });

        $('#sp_banner_img').on('change', function() {
            if (document.getElementById("sp_banner_img").files.length == 0) {
                // $(".custom-file-label").text("{{ __('messages.select_banner_image') }}");
                $(this).next('.custom-file-label').text("{{ __('messages.select_banner_image') }}");
            }
        });

        function validateProfilePicSp(file) {
            var re = /(\.png|\.jpg|\.bmp|\.jpeg)$/i;
            if (!re.exec(file.files[0].name)) {
                alert("{{ __('messages.valid_profile_pic') }}");
                $('#sp_banner_img').val('');
                $('#sp_banner_img').text("{{ __('messages.select_banner_image') }}");

            } else if (file.files[0].size > 2048000) // 2 MiB for bytes.
            {
                alert("{{ __('messages.file_size_desc') }}");
                $('#sp_banner_img').text("{{ __('messages.select_banner_image') }}");
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
                        $('#sp_banner_img').text("{{ __('messages.select_banner_image') }}");
                        return false;
                    }
                    _URLSP.revokeObjectURL(objectUrlSp);
                };
                imgSp.src = objectUrlSp;
            }
        }

        $('#addAdsForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ Route('add_ads') }}",
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
                        $('#addAds').prop('disabled', false);
                        $('#addAdsForm').get(0).reset();
                        $(".custom-file-label").text("{{ __('messages.select_banner_image') }}");
                        swal({
                            title: data.msg,
                            text: "",
                            type: "success",
                            icon: "success",
                            showConfirmButton: true
                        }).then(function() {
                            // window.location.href = "{{ route('home') }}";
                        });
                    }
                }
            });
        });
    </script>
@endsection
