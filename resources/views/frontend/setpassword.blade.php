@extends('frontend.layout')
@section('maincontent')
    @parent
    <!-- ============================ Hero Banner  Start================================== -->
    <div class="page-title-wrap pt-img-wrap"
        style="background:url({{ asset('frontend/assets/img/home_page_bg_one.jpg') }}) no-repeat;">
        <div class="container">
            <div class="col-lg-12 col-md-12">
                <div class="pt-caption text-center">
                    <h1>{{ __('messages.reset_password') }}</h1>
                    <p><a href="{{ Route('home') }}">{{ __('messages.home_home') }}</a><span
                            class="current-page">{{ __('messages.reset_password') }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- ============================ Hero Banner End ================================== -->

    <!-- ============================ Who We Are Start ================================== -->
    <section class="gray">
        <div class="container">

            <div class="row">
                <div class="col-lg-3 col-md-3">
                </div>
                <div class="col-lg-6 col-md-6">
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
                    </div>
                    <div class="contact-form">
                        <form id="updatePassword">
                            @csrf
                            <div class="form-group">
                                <label>{{ __('messages.enter_new_password') }}</label>
                                <div class="input-group" id="show_hide_fpassword">
                                    <input class="form-control" autocomplete="new-password" id="newpassword"
                                        placeholder="*******"
                                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                        title="{{ __('messages.password_should') }}" name="newpassword" type="password"
                                        style="background: #f3f4f5;" required>
                                    <div class="input-group-addon" style="border: none;background: #f3f4f5;">
                                        <a href=""><i class="fa fa-eye-slash text-success"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                {{-- <div class="input-with-gray">
                                    <input type="password" class="form-control" id="newpassword" name="newpassword"
                                        placeholder="{{ __('messages.Password') }}" onselectstart="return false"
                                        onpaste="return false;" onCopy="return false" onCut="return false"
                                        onDrag="return false" onDrop="return false"
                                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                        title="password should have 1 uppercase, 1 lowercase, 1 number, 1 special character and minimum 6 characters"
                                        required>
                                    <i class="ti-unlock theme-cl"></i>
                                </div> --}}
                            </div>
                            <div class="form-group">
                                <label>{{ __('messages.Confirmed_Password') }}</label>
                                <div class="input-group" id="show_hide_fcpassword">
                                    <input class="form-control" autocomplete="new-password" id="newcpassword"
                                        placeholder="*******"
                                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                        title="{{ __('messages.password_should') }}" name="cpassword" type="password"
                                        style="background: #f3f4f5;" required>
                                    <div class="input-group-addon" style="border: none;background: #f3f4f5;">
                                        <a href=""><i class="fa fa-eye-slash text-success"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </div>

                                <input type="hidden" name="request_id" value="{{ $data['request_id'] }}">
                                <input type="hidden" name="token" value="{{ $data['token'] }}">
                                <span id='msgError'></span>
                            </div>
                            <input type="hidden" name="user_id" value="{{ $data['User']->id }}">
                            <button type="submit"
                                class="btn btn-primary full-width">{{ __('messages.reset_password') }}</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                </div>

            </div>

        </div>
    </section>
    <div class="clearfix"></div>
    <!-- ============================ Who We Are End ================================== -->
@endsection

@section('mainscript')
    @parent
    <script>
        $("#show_hide_fpassword a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_fpassword input').attr("type") == "text") {
                $('#show_hide_fpassword input').attr('type', 'password');
                $('#show_hide_fpassword i').addClass("fa-eye-slash");
                $('#show_hide_fpassword i').removeClass("fa-eye");
            } else if ($('#show_hide_fpassword input').attr("type") == "password") {
                $('#show_hide_fpassword input').attr('type', 'text');
                $('#show_hide_fpassword i').removeClass("fa-eye-slash");
                $('#show_hide_fpassword i').addClass("fa-eye");
            }
        });
        $("#show_hide_fcpassword a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_fcpassword input').attr("type") == "text") {
                $('#show_hide_fcpassword input').attr('type', 'password');
                $('#show_hide_fcpassword i').addClass("fa-eye-slash");
                $('#show_hide_fcpassword i').removeClass("fa-eye");
            } else if ($('#show_hide_fcpassword input').attr("type") == "password") {
                $('#show_hide_fcpassword input').attr('type', 'text');
                $('#show_hide_fcpassword i').removeClass("fa-eye-slash");
                $('#show_hide_fcpassword i').addClass("fa-eye");
            }
        });
        $('#updatePassword').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ Route('update_password') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {

                },
                success: function(data) {
                    if (data.status == 0) {

                        $('#msgError').html(data.msg).css(
                            'color',
                            'red');
                    } else {
                        $('#msgError').html('');
                        $('#updatePassword').get(0).reset();
                        swal({
                            title: data.msg,
                            text: "",
                            type: "success",
                            icon: "success",
                            showConfirmButton: true
                        }).then(function() {
                            window.location.href = "{{ route('home') }}";
                            // location.reload();
                        });
                    }
                }
            });
        });

        $('#newpassword').on('keyup change', function() {

            if ($('#newpassword').val() == "") {
                $('#msgError').html("{{ __('messages.Please_enter_new_password') }}").css('color', 'red');
                $(':input[type="submit"]').prop('disabled', true);
            } else if ($('#newcpassword').val() == "") {
                $('#msgError').html("{{ __('messages.Please_enter_confirm_password') }}").css('color', 'red');
                $(':input[type="submit"]').prop('disabled', true);
            } else if ($('#newcpassword').val().length != 0) {
                if ($('#newpassword').val() == $('#newcpassword').val()) {
                    $('#msgError').html('');
                    $(':input[type="submit"]').prop('disabled', false);
                } else {
                    $('#msgError').html("{{ __('messages.password_must_match') }}").css('color', 'red');
                    $(':input[type="submit"]').prop('disabled', true);
                }
            } else {
                $('#msgError').html('');
                $(':input[type="submit"]').prop('disabled', false);
            }
        });

        $('#newcpassword').on('keyup change', function() {
            if ($('#newpassword').val() == $('#newcpassword').val()) {
                // $('#msgError').html('Matching').css('color', 'green');
                $('#msgError').html('');
                $(':input[type="submit"]').prop('disabled', false);
            } else {
                $('#msgError').html("{{ __('messages.password_must_match') }}").css('color', 'red');
                $(':input[type="submit"]').prop('disabled', true);
            }
        });
    </script>
@endsection
