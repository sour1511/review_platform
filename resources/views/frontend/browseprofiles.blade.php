@extends('frontend.layout')
@section('maincontent')
    @parent
    <!-- ============================ Search Form Start================================== -->
    <section class="light-search banncer-cent bg-theme" data-overlay="0">
        <div class="container">

            <form class="search-big-form no-border search-shadow">
                <div class="row m-0">

                    <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                        <div class="form-group">
                            <input type="text" title="{{ __('messages.review_profile_name') }}" id="profile_name"
                                name="profile_name" placeholder="{{ __('messages.review_profile_name') }}"
                                class="form-control">
                            <i class="ti-search"></i>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                        <div class="form-group">
                            <select id="category" onchange="getSubCategory()" class="js-states form-control">
                                <option value="">&nbsp;</option>
                                {{-- <option value="All">All Category</option> --}}
                                @if ($data['categories']->count() > 0)
                                    @if (Session::get('locale') == 'en')
                                        @foreach ($data['categories'] as $category)
                                            @if($category->category_title != null)
                                                <option value="{{ $category->id }}">{{ $category->category_title }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($data['categories'] as $category)
                                            @if($category->es_category_title != null)
                                                <option value="{{ $category->id }}">{{ $category->es_category_title }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                            <i class="ti-search"></i>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                        <div class="form-group">
                            <i class="ti-layers"></i>
                            <select class="form-control" id="subcate" name="sub_cat">
                                <option value="">&nbsp;</option>
                            </select>
                            {{-- <input type="text" class="form-control b-r" placeholder="Choose Subcategory"> --}}
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                        <div class="form-group">
                            <i class="ti-location-pin"></i>
                            {{-- <input type="text" name="location_name" id="location_name" class="form-control b-r"
                                placeholder="Location"> --}}
                            <input type="text" id="address-input" name="address_address"
                                placeholder="{{ __('messages.location') }}" class="form-control map-input">
                            <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                            <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                        </div>
                    </div>
                    <div class="d-none" id="address-map-container" style="width:100%;height:400px; ">
                        <div style="width: 100%; height: 100%" id="address-map"></div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-12 p-0">
                        <button type="button" id="search_cat"
                            class="btn btn-black p-0 black full-width">{{ __('messages.search') }}</button>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-12 p-0">
                        <button type="button"
                            class="btn btn-warning p-0 full-width clearFilter">{{ __('messages.clear') }}</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
    <!-- ============================ Search Form End ================================== -->

    <!-- ============================ Breadcrums Start================================== -->
    <div class="container-fluid breadcrumbs breadcrumbs-light">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <a href="{{ Route('home') }}">
                        {{ __('messages.home_home') }}
                    </a>
                    <a href="javascript:void(0)">
                        <span>
                            <i class="ti-arrow-right"></i>
                        </span>
                        {{ __('messages.browse_review_profiles') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- ============================ Breadcrums End ================================== -->

    <!-- ============================ Start Freelancers ================================== -->
    <section>
        <div class="container profilesListViewClass">

            <div id="profilesListView">
                @include('frontend.profile_ajax_list')
            </div>

        </div>
    </section>
    {{-- @if (empty(Session::get('login_username')))
        <section class="pt-0">
            <div class="container text-center">
                <a href="{{ route('user_login_page') }}" class="btn btn-md btn-outline-info btn-rounded mb-3">View
                    More</a>
            </div>
        </section>
    @endif --}}
    <div class="clearfix"></div>
    <!-- ============================ Start Freelancers ================================== -->
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
    <script type="text/javascript">
        $('#category').select2({
            placeholder: "{{ __('messages.choose_a_category') }}",
            allowClear: true
        });

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

        $(".clearFilter").click(function(ev) {
            // location.reload();  
            if ($('#profile_name').val().length > 0 || $('#category option:selected').val().length > 0 || $(
                    '#subcate option:selected').val().length > 0 ||
                $('#address-input').val().length > 0) {
                $("#category").val('').trigger('change');
                $("#subcate").val('').trigger('change');
                $("#address-input").val('');
                $("#profile_name").val('');

                $.ajax({
                    url: "{{ Route('getprofilesfilter') }}",
                    data: {
                        'cat_id': '',
                        'subcat_id': '',
                        'location_name': '',
                        'profile_name': '',
                    },
                    success: function(data) {
                        $('#profilesListView').html(data);
                    }
                });
            } else {
                $.ajax({
                    url: "{{ Route('getprofilesfilter') }}",
                    data: {
                        'cat_id': '',
                        'subcat_id': '',
                        'location_name': '',
                        'profile_name': '',
                    },
                    success: function(data) {
                        $('#profilesListView').html(data);
                    }
                });
            }
        });

        $('#subcate').select2({
            placeholder: "{{ __('messages.choose_a_subcategory') }}",
            allowClear: true
        });

        $(document).ready(function() {

            var pageNo = "";
            var callFromPagination = 0;
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                pageNo = $(this).attr('href').split('page=')[1];
                callFromPagination = 1;
                getProfileData();
            });

            function getProfileData() {
                if (callFromPagination == 0) {
                    pageNo = 1; // call from other than pagination
                }
                var cat_id = $('#category option:selected').val();
                var subcat_id = $('#subcate option:selected').val();
                var location_name = $('#address-input').val();
                var profile_name = $('#profile_name').val();

                $.ajax({
                    url: "{{ Route('getprofilesfilter') }}",
                    data: {
                        'cat_id': cat_id,
                        'subcat_id': subcat_id,
                        'location_name': location_name,
                        'profile_name': profile_name,
                        'page': pageNo
                    },
                    success: function(data) {
                        callFromPagination = 0;
                        $('#profilesListView').html(data);
                        $('html, body').animate({
                            scrollTop: $(".profilesListViewClass").offset().top - 200
                        }, 1000);
                    }
                });
            }

            $("#search_cat").click(function() {

                if ($('#profile_name').val().length > 0 || $('#category option:selected').val().length >
                    0 || $('#subcate option:selected').val()
                    .length > 0 || $('#address-input').val().length > 0) {
                    getProfileData();
                } else {
                    swal({
                        title: "{{ __('messages.please_select_fields') }}",
                        text: "{{ __('messages.please_select_fields_desc') }}",
                        icon: "warning",
                        button: true
                    });
                }
            });

        });

        function getSubCategory() {
            var catgory_id = $('#category option:selected').val();
            if (catgory_id != "") {
                $.ajax({
                    type: "POST",
                    url: "{{ Route('getsubcategory') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "category_id": catgory_id
                    },
                    success: function(data) {
                        $('#subcate').html(data);
                    }
                });
            }
        }
    </script>
@endsection
