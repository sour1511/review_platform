@extends('frontend.layout')
@section('maincontent')
    @parent
    <!-- ============================ Hero Banner  Start================================== -->
    <div class="page-title-wrap pt-img-wrap"
        style="background:url({{ asset('frontend/assets/img/home_page_bg_one.jpg') }}) no-repeat;">
        <div class="container">
            <div class="col-lg-12 col-md-12">
                <div class="pt-caption text-center">
                    <h1>{{ __('messages.Sign_In') }}</h1>
                    <p><a href="{{ Route('home') }}">{{ __('messages.home_home') }}</a><span
                            class="current-page">{{ __('messages.Sign_In') }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- ============================ Hero Banner End ================================== -->

    <section class="gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3"></div>
                <div class="col-lg-6 col-md-6">
                    <div class="contact-form bg-white p-4">
                        <h4 class="mb-4 text-center">{{ __('messages.Sign_In') }}</h4>
                        <div class="login-form">
                            <form id="loginUserForm" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('messages.email') }}</label>
                                    <div class="input-with-gray">
                                        <input type="email" id="lemail" class="form-control" name="email"
                                            placeholder="{{ __('messages.email') }}" autocomplete="username">
                                        <i class="ti-user theme-cl"></i>
                                    </div>
                                    <span class="text-danger error-text lemail_error"></span>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.Password') }}</label>
                                    <div class="input-group" id="show_hide_spassword">
                                        <input class="form-control" autocomplete="current-password" id="lpassword"
                                            placeholder="{{ __('messages.Password') }}" name="password" type="password"
                                            style="background: #f3f4f5;">
                                        <div class="input-group-addon" style="border: none;background: #f3f4f5;">
                                            <a href=""><i class="fa fa-eye-slash text-success"
                                                    aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <span id="loginmessage"></span>
                                    <span class="text-danger error-text lpassword_error"></span>
                                </div>

                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary btn-md full-width pop-login">{{ __('messages.Login') }}</button>
                                </div>
                            </form>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                            <div class="mf-link mb-2">
                                <i class="ti-user"></i>{{ __('messages.Haven_got_an_account') }}
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#signup">
                                    {{ __('messages.Sign_Up') }}</a>
                            </div>
                            <div class="mf-forget mb-2">
                                <a href="#" data-toggle="modal" data-target="#forget_password" id="forget_click">
                                    {{ __('messages.Forgot_password') }}<i class="ti-help"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3"></div>
            </div>
        </div>
    </section>
@endsection
