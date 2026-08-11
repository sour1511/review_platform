@extends('frontend.layout')
@section('maincontent')
    @parent
    <!-- ============================ Hero Banner  Start================================== -->
    <div class="page-title-wrap pt-img-wrap"
        style="background:url({{ asset('frontend/assets/img/home_page_bg_one.jpg') }}) no-repeat;">
        <div class="container">
            <div class="col-lg-12 col-md-12">
                <div class="pt-caption text-center">
                    <h1>{{ __('messages.Get_in_Touch') }}</h1>
                    <p><a href="{{ Route('home') }}">{{ __('messages.home_home') }}</a><span
                            class="current-page">{{ __('messages.contact_us') }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- ============================ Hero Banner End ================================== -->

    <!-- ============================ Who We Are Start ================================== -->
    <section class="gray" id="contact_us">
        <div class="container">

            <div class="row">

                <div class="col-lg-5 col-md-5 bg-white">
                    <div class="contact-address">
                        {{-- <div class="add-box">
                            <div class="add-icon-box">
                                <i class="ti-home theme-cl"></i>
                            </div>
                            <div class="add-text-box">
                                <h4>Workio Limited</h4>
                                CEO: Sagar Singh<br>
                                CFO: Shaurya Singh<br>
                            </div>
                        </div> --}}

                        <div class="add-box">
                            <div class="add-icon-box">
                                <i class="ti-map-alt theme-cl"></i>
                            </div>
                            <div class="add-text-box">
                                <h4>{{ __('messages.HEAD_OFFICES') }}</h4>
                                Canada</br>Toronto Ontario</br>Costa
                                Rica</br>Alajuela
                            </div>
                        </div>

                        <div class="add-box">
                            <div class="add-icon-box">
                                <i class="ti-email theme-cl"></i>
                            </div>
                            <div class="add-text-box">
                                <h4>{{ __('messages.email') }}</h4>
                                info@quejasyelogios.com<br>
                            </div>
                        </div>
                        {{-- <div class="add-box">
                            <div class="add-icon-box">
                                <i class="ti-headphone theme-cl"></i>
                            </div>
                            <div class="add-text-box">
                                <h4>Calls</h4>
                                91+ 123 456 9857<br>
                                91+ 258 548 5426<br>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="contact-form">
                        <form action="{{ route('contactemail') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('messages.name') }}</label>
                                    <input type="text" name="name"
                                        oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                        oninput="setCustomValidity('')" id="contact_name" class="form-control first_name"
                                        placeholder="{{ __('messages.name') }}" required>
                                    <span class="text-danger error-text name_error"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{ __('messages.email') }}</label>
                                    <input type="email" name="email"
                                        oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                        oninput="setCustomValidity('')" id="contact_email" class="form-control"
                                        placeholder="{{ __('messages.email') }}" required>
                                    <span class="text-danger error-text email_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ __('messages.subject') }}</label>
                                <input type="text" oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                    oninput="setCustomValidity('')" name="subject" id="subject" class="form-control"
                                    placeholder="{{ __('messages.subject') }}" required>
                            </div>
                            <div class="form-group">
                                <label>{{ __('messages.message') }}</label>
                                <textarea class="form-control" id="message" oninvalid="this.setCustomValidity('{{ __('messages.fill_out') }}')"
                                    oninput="setCustomValidity('')" name="message" placeholder="{{ __('messages.type_here') }}" required></textarea>
                            </div>
                            <div class="form-group">
                                @if (!empty(config('services.recaptcha.key')))
                                    <strong>ReCaptcha:</strong>
                                    <div class="g-recaptcha"
                                        data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                                @elseif (app()->environment('local'))
                                    <input type="hidden" name="g-recaptcha-response" value="local-dev">
                                @endif
                                @error('g-recaptcha-response')
                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="full-width">
                                @if (Session::has('error'))
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

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ $errors->first() }}
                                    </div>
                                @endif
                            </div>
                            <button type="submit" id="eSend"
                                class="btn btn-primary">{{ __('messages.send') }}</button>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </section>
    <div class="clearfix"></div>
    <!-- ============================ Who We Are End ================================== -->
    <!-- ============================ custom ads Start ================================== -->
    @php
        $is_show_ads = '';
        
        if (isset($data['custom_ads']) && $data['custom_ads']->count() > 0) {
            if (isset($data['ad_settings']) && $data['ad_settings']->count() > 0) {
                if ($data['ad_settings']->is_hide == 0) {
                    $is_show_ads = '';
                } else {
                    $is_show_ads = 'd-none';
                }
            }
        } else {
            $is_show_ads = 'd-none';
        }
        
    @endphp
    <section class="custom {{ $is_show_ads }}">
        <div class="container">

            <div class="row">
                <div class="col text-center">
                    <div class="sec-heading mx-auto">
                        <p>{{ __('messages.sponsored') }}</p>
                        {{-- <h2>See Latest Updates</h2> --}}
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div class="owl-carousel" id="custom_ads">
                        @if (isset($data['custom_ads']) && $data['custom_ads']->count() > 0)
                            @foreach ($data['custom_ads'] as $customAd)
                                @if (Session::get('locale') == 'en')
                                    @if ($customAd->banner_img != '' || $customAd->banner_img != null)
                                        <div class="item">
                                            {{-- <div class="col-lg-4 col-md-4"> --}}
                                            <div class="blog-grid-wrap mb-4">
                                                <div class="blog-grid-thumb">
                                                    <a href="#"><img style="height: 280px;"
                                                            src="{{ asset($customAd->banner_img) }}" class=""
                                                            alt=""></a>
                                                    {{-- <div class="bg-cat-info">
                                        <div class="post-m-info">
                                            <h5 class="pm-date">12</h5>
                                            <h5 class="pm-month">Dec</h5>
                                        </div>
                                    </div>
                                    <h6 class="post-cat">Travel &amp; Tour</h6> --}}
                                                </div>
                                                <div class="blog-grid-content">
                                                    <h4 class="cnt-gb-title"><a href="#">{{ $customAd->heading }}</a>
                                                    </h4>
                                                    @if ($customAd->sub_heading != null)
                                                        <p>{{ $customAd->sub_heading }}</p>
                                                    @endif
                                                </div>
                                                {{-- <div class="blog-grid-meta">
                                    <div class="gb-info-author">
                                        <p><strong>By </strong>Javid Akhtar</p>
                                    </div>
                                    <div class="gb-info-cmt">
                                        <ul>
                                            <li><a href="#">110<i class="fa fa-comment text-info"></i></a>
                                            </li>
                                            <li><a href="#">50<i class="fa fa-heart text-info"></i></a></li>
                                        </ul>
                                    </div>
                                </div> --}}
                                            </div>
                                            {{-- </div> --}}
                                        </div>
                                    @endif
                                @else
                                    @if ($customAd->sp_banner_img != '' || $customAd->sp_banner_img != null)
                                        <div class="item">
                                            <div class="blog-grid-wrap mb-4">
                                                <div class="blog-grid-thumb">
                                                    <a href="#"><img style="height: 280px;"
                                                            src="{{ asset($customAd->sp_banner_img) }}" class=""
                                                            alt=""></a>
                                                </div>
                                                <div class="blog-grid-content">
                                                    <h4 class="cnt-gb-title"><a
                                                            href="#">{{ $customAd->sp_heading }}</a>
                                                    </h4>
                                                    @if ($customAd->sp_sub_heading != null)
                                                        <p>{{ $customAd->sp_sub_heading }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ============================ custom ads End ================================== -->

@endsection

@section('mainscript')
    @parent
    <script>
        $("#custom_ads").owlCarousel({
            loop: true,
            autoplay: true,
            center: true,
            items: 3,
            nav: true,
            dots: true,
            margin: 30,
            responsiveClass: true,
            autoplayHoverPause: true,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    // nav: false
                },
                600: {
                    items: 1,
                    // nav: false
                },
                1000: {
                    items: 1,
                    // nav: false,
                    loop: true
                }
            }
        });

        $(".first_name").keypress(function(e) {
            var keyCode = e.keyCode || e.which;
            $(".name_error").html("");
            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[A-Za-z\s]+$/;
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $(".name_error").html("{{ __('messages.Only_Alphabets') }}");
            }
            return isValid;
        });

        $('#contact_email').on('change', function() {
            var validEmail = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test($("#contact_email").val());
            if (!validEmail) {
                $(".email_error").html("{{ __('messages.valid_email') }}");
                $("#contact_email").focus();
                $('#eSend').prop('disabled', true);
                return false;
            } else {
                $(".email_error").html("");
                $('#eSend').prop('disabled', false);
            }
        });
    </script>
@endsection
