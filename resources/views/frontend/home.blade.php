@extends('frontend.layout')
@section('maincontent')
    @parent
    <style>
        .category_title {
            background: rgba(0, 168, 107, 0.1);
            border: 1px solid rgba(0, 168, 107, 0.1);
            color: #000000;
            /* margin-right: 10px; */
            margin-top: 4px;
            margin-bottom: 4px;
            /* display: inline-block; */
            padding: 4px 12px;
            font-size: 13px;
            border-radius: 0.2rem;
        }

        .job-grid-wrap {
            padding: 0 !important;
            text-align: center;
        }
    </style>    
    @if (Session::has('message'))       
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ Session::get('message') }}
        </div>
    @endif
    <!-- ============================ Hero Banner  Start================================== -->
    <div class="hero-header jumbo-banner text-center" style="background: url({{ asset('frontend/assets/img/home_page_bg_one.jpg') }});" data-overlay="6">
        <div class="container">
            @if (empty(Session::get('login_username')))
            <h2 style="line-height: initial;">{{ __('messages.home_heading_search') }} <a href="{{ route('user_login_page') }}" style="color: white;"><u>{{ __('messages.home_subheading_search_create') }}</u></a> {{ __('messages.home_subheading_search') }} </h2>
            @else    
            <h2 style="line-height: initial;">{{ __('messages.home_heading_search') }} <a href="{{ Route('review_profile') }}" style="color: white;"><u>{{ __('messages.home_subheading_search_create') }}</u></a> {{ __('messages.home_subheading_search') }} </h2>
            @endif

            {{-- @if (empty(Session::get('login_username')))
                <p class="lead">{{ __('messages.home_subheading_search') }} <a href="{{ route('user_login_page') }}" style="color: white;"><u>{{ __('messages.home_subheading_search_create') }}</u></a>
                </p>
            @else
                <p class="lead">{{ __('messages.home_subheading_search') }}<a href="{{ Route('review_profile') }}"
                        style="color: white;"><u>{{ __('messages.home_subheading_search_create') }}</u></a></p>
            @endif --}}
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

                    <div class="col-lg-1 col-md-1 col-sm-12 p-0 text-center">
                        <button type="button" id="search_cat"
                            class="btn btn-primary p-0 full-width">{{ __('messages.search') }}</button>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-12 p-0">
                        <button type="button"
                            class="btn btn-dark p-0 full-width clearFilter">{{ __('messages.clear') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- ============================ Hero Banner End ================================== -->

     <!-- ============================ learn Start ================================== -->
     <section class="gray">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="mx-auto">
                        {{-- <p>{{ __('messages.browse_review_profiles_by_category') }}</p> --}}
                        <h2><a href="{{__('messages.wixlink_address')}}" target="_blank"><u>{{ __('messages.wix_link')}}</u></a> {{ __('messages.wix_link_header') }}</h2>
                    </div>
                </div>
            </div> 
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- ============================ learn End ================================== -->

    <!-- ============================ Latest profiles ================================== -->
    <section>
        <div class="container popularList d-none">

            <div class="row">
                <div class="col text-center">
                    <div class="sec-heading mx-auto">
                        <p>{{ __('messages.review_profiles_by_country') }}</p>
                        <h2>{{ __('messages.check_review_profiles_in_your_area') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row" style="display: block;">
                <div id="mostPopularlist">
                </div>
            </div>

        </div>

        <div class="container mostPopular">

            <div class="row">
                <div class="col text-center">
                    <div class="sec-heading mx-auto">
                        <p>{{ __('messages.review_profiles_by_country') }}</p>
                        <h2>{{ __('messages.check_review_profiles_in_your_area') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="owl-carousel" id="job-slide">
                    {{-- @if (isset($data['profilesData']) && $data['profilesData']->count() > 0)
                        @foreach ($data['profilesData'] as $profiledata)
                            <!-- Single Job -->
                            <div class="item">
                                <div class="job-grid style-1">
                                    <div class="job-grid-wrap">
                                        @php
                                            // get current profile all reviews
                                            $totalReview = \App\Models\Review::where('reviews.profile_id', $profiledata->id)
                                                ->where('reviews.is_delete', 0)
                                                ->get();
                                            $reviewCount = $totalReview->count();
                                            $finalStar = 0;
                                            if ($reviewCount > 0) {
                                                $totalStar = 0;
                                                foreach ($totalReview as $tReview) {
                                                    $totalStar = $totalStar + (int) $tReview->star_ratings;
                                                }
                                                $finalStar = round($totalStar / $reviewCount);
                                            }
                                            
                                        @endphp
                                        @if ($finalStar >= 4)
                                            <div class="featured-job"><i class="ti-star filled"></i></div>
                                        @endif
                                        <span class="job-type j-full-time">Full Time</span>
                                        <div class="job-grid-thumb">
                                            <a href="#">
                                                @if ($profiledata->profile_pic != null)
                                                    <img width="80px;" height="80px"
                                                        src="{{ asset($profiledata->profile_pic) }}"
                                                        class="img-fluid mx-auto" alt="user image" />
                                                @else
                                                    <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                        class="img-fluid mx-auto" alt="user image" />
                                                @endif
                                        </div>
                                        @if ($profiledata->profile_name == null)
                                            <h4 class="job-title mt-1"><a href="#">{{ $profiledata->name }}</a></h4>
                                        @else
                                            <h4 class="job-title mt-1"><a
                                                    href="#">{{ $profiledata->profile_name }}</a></h4>
                                        @endif
                                        <hr>
                                        <div class="job-grid-detail">
                                            <h4 class="jbc-name" style="font-size: 13px;"><a href="#"><b>Category:</b>
                                                    {{ $profiledata->category_title }}, <b>Subcategory:</b>
                                                    {{ $profiledata->sub_category_title }}</a></h4>
                                            <p><i class="ti-location-pin"></i>{{ $profiledata->location }} </p>
                                        </div>
                                        <div class="text-center">
                                            <a href="{{ Route('profiledetails', ['id' => $profiledata->id]) }}"
                                                class="btn btn-md btn-outline-info btn-rounded mb-3">View More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif --}}
                    @include('frontend.popularprofiles')
                </div>
                @if (empty(Session::get('login_username')))
                    <div class="container text-center mt-3">
                        <a href="{{ route('user_login_page') }}" class="btn btn-md btn-outline-info mb-3">{{ __('messages.view_more') }}</a>
                    </div>
                @endif
            </div>

        </div>
    </section>
    {{-- @if (empty(Session::get('login_username')))
        <section class="pt-0">
            <div class="container text-center">
                <a href="{{ route('user_login_page') }}" class="btn btn-md btn-outline-info mb-3">View
                    More</a>
            </div>
        </section>
    @endif --}}
    <!-- ============================ Latest profiles End ================================== -->
    <!-- ============================ Counter Facts  Start================================== -->
    <section class="image-bg text-center" style="background:#00a94f url({{ asset('frontend/assets/img/bg2.png') }});"
    data-overlay="0">
    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-6 b-r">
                <div class="count-facts">
                    <h4>{{ $data['profilesDataCount']->count() }}</h4>
                    <span>{{ __('messages.home_review_profiles') }}</span>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 b-r">
                <div class="count-facts">
                    <h4>{{ $data['reviewsDataCount']->count() }}</h4>
                    <span>{{ __('messages.reviews') }}</span>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="count-facts">
                    <h4>{{ $data['users']->count() }}</h4>
                    <span>{{ __('messages.users') }}</span>
                </div>
            </div>

            {{-- <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="count-facts">
                    <h4>3740</h4>
                    <span>Freelancer</span>
                </div>
            </div> --}}

        </div>
    </div>
    </section>
    <!-- ============================ Counter Facts End ================================== -->
    
    <!-- ============================ Popular Reviews Start ================================== -->
    <!--section>
        <div class="container">

            <div class="row">
                <div class="col text-center">
                    <div class="sec-heading mx-auto">
                        <p>{{ __('messages.check_the_most_commended') }}</p>
                        <h2>{{ __('messages.top_ten_most') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if (isset($data['reviewsData']) && $data['reviewsData']->count() > 0)
                        @foreach ($data['reviewsData'] as $revData)
                            @if (Session::get('locale') == 'en')  
                                @if ($revData->category_title != null && $revData->sub_category_title != null)
                                    <div class="verticle-job-modern">

                                        <div class="verticle-job-top-capt">
                                            <div class="col-md-12 text-center">
                                                @if ($revData->profile_name == null)
                                                    <h4 class="m-1">{{ $revData->name }}</h4><br>
                                                @else
                                                    <h4 class="m-1">{{ $revData->profile_name }}</h4><br>
                                                @endif
                                            </div>
                                            <div class="vjt-left-cmp">
                                                <div class="vjt-cmp-thumb m-1">
                                                    <a href="javascript:function() { return false; }">
                                                        @if ($revData->user_pic != null)
                                                            @if ($revData->self_consent == 1)
                                                                <img src="{{ asset($revData->user_pic) }}" alt="user image" />
                                                            @else
                                                                @if ($revData->show_realname == 1)
                                                                    <img src="{{ asset($revData->user_pic) }}"
                                                                        alt="user image" />
                                                                @else
                                                                    @if ($revData->avatar_pic != null)
                                                                        <img src="{{ asset($revData->avatar_pic) }}"
                                                                            alt="user image" />
                                                                    @else
                                                                        <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                                            alt="user image" />
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                                alt="user image" />
                                                        @endif
                                                        {{-- @if ($revData->user_pic != null)
                                                                <img src="{{ asset($revData->user_pic) }}" alt="user image" />
                                                            @else
                                                                <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                                    alt="user image" />
                                                            @endif --}}
                                                    </a>
                                                </div>
                                                <span class="float-right">
                                                    @if ($revData->star_ratings == '-1')
                                                        <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '-2')
                                                        <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '-3')
                                                        <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '-4')
                                                        <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '-5')
                                                        <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                                    @endif

                                                    @if ($revData->star_ratings == '1')
                                                        <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '2')
                                                        <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '3')
                                                        <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '4')
                                                        <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '5')
                                                        <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                    @endif

                                                    {{-- @if ($revData->user_id == Session::get('login_user_id'))
                                                        <i style="cursor: pointer;" class="fa fa-edit fa-lg mr-3"
                                                            onclick="editReviewViewLoad('{{ $revData->id }}')"
                                                            aria-hidden="true"></i>
                                                        <i style="cursor: pointer;" class="fa fa-trash fa-lg"
                                                            onclick="removeReview('{{ $revData->id }}')" aria-hidden="true"></i>
                                                    @endif --}}
                                                </span>
                                                <div class="vjt-cmp-title">
                                                    @if ($revData->self_consent != 1)
                                                        @if ($revData->nick != null)
                                                            @if ($revData->show_realname == 1)
                                                                <h4 class="jmg-title">{{ $revData->name }} {{ $revData->lname }}
                                                                </h4>
                                                            @else
                                                                <h4 class="jmg-title">{{ $revData->nick }}</h4>
                                                            @endif
                                                        @else
                                                            <h4 class="jmg-title">{{ $revData->name }} {{ $revData->lname }}</h4>
                                                        @endif
                                                    @else
                                                        <h4 class="jmg-title">{{ $revData->name }} {{ $revData->lname }}</h4>
                                                    @endif
                                                    {{-- @if ($revData->nickname != null)
                                                        <h4 class="jmg-title">{{ $revData->nickname }}</h4>
                                                    @else
                                                        <h4 class="jmg-title">{{ $revData->name }}</h4>
                                                    @endif --}}
                                                    @if (Session::get('locale') == 'en')
                                                        <span class="category_title"><b>{{ __('messages.category') }}:</b>
                                                            {{ $revData->category_title }},
                                                            <b>{{ __('messages.subcategory') }}:</b>
                                                            {{ $revData->sub_category_title }}</span><br>
                                                    @else
                                                        <span class="category_title"><b>{{ __('messages.category') }}:</b>
                                                            {{ $revData->es_category_title }},
                                                            <b>{{ __('messages.subcategory') }}:</b>
                                                            {{ $revData->es_sub_category_title }}</span><br>
                                                    @endif

                                                    <span class="rating-review mt-1">
                                                        {{-- {{ $revData->star_ratings }} --}}
                                                        @if ($revData->star_ratings == '-1')
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                        @endif
                                                        @if ($revData->star_ratings == '-2')
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                        @endif
                                                        @if ($revData->star_ratings == '-3')
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                        @endif
                                                        @if ($revData->star_ratings == '-4')
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                        @endif
                                                        @if ($revData->star_ratings == '-5')
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                            <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                                style="color: #ff4545"></i>
                                                        @endif

                                                        @if ($revData->star_ratings == '1')
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                        @endif
                                                        @if ($revData->star_ratings == '2')
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                        @endif
                                                        @if ($revData->star_ratings == '3')
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                        @endif
                                                        @if ($revData->star_ratings == '4')
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                        @endif
                                                        @if ($revData->star_ratings == '5')
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                                style="color: #ffa534"></i>
                                                        @endif
                                                        {{-- @if ($revData->star_ratings == '0')
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        @endif --}}
                                                    </span>

                                                    {{-- <h6 class="vjt-company-title"><a href="#">Dribbble</a></h6> --}}
                                                </div>
                                            </div>
                                            <div class="vjt-right-cmp">
                                                {{-- <h4 class="jmg-sallery">$1200 - $1500 PLN</h4> --}}
                                            </div>
                                        </div>

                                        <div class="verticle-job-bottom-capt">
                                            <div class="vjt-skills">
                                                <div class="tr-single-body">
                                                    <p>
                                                        {{ $revData->review_description }}
                                                    </p>
                                                </div>
                                                {{-- <span class="skl">Web Design</span><span class="skl">PHP</span><span class="skl">3 more</span> --}}

                                                <div class="vjt-metainfo">
                                                    <span><i class="ti-location-pin"></i>{{ $revData->user_country }}</span>
                                                    {{-- <span><i class="ti-briefcase"></i>Full Time</span> --}}
                                                    <span><i class="ti-calendar"></i>{{ __('messages.Post_Date') }}:
                                                        {{ $revData->post_date }}</span>
                                                    @if ($revData->type == 'Commendation')
                                                        <span><i class="ti-calendar"></i>{{ __('messages.Review_Type') }}:
                                                            {{ __('messages.Commendation') }}</span>
                                                    @else
                                                        <span><i class="ti-calendar"></i>{{ __('messages.Review_Type') }}:
                                                            {{ __('messages.Complaint') }}</span>
                                                    @endif
                                                    @if ($revData->self_consent == 1)
                                                        <span>{{ __('messages.Verified_Review') }} <i class="fa fa-check mr-0"
                                                                aria-hidden="true"></i><i class="fa fa-check"
                                                                aria-hidden="true"></i></span>
                                                    @else
                                                        <span>{{ __('messages.Unverified_Review') }}</span>
                                                    @endif
                                                    @if ($revData->doc_name != null)
                                                        <span class="text-success"> <a style="color:#00A86B !important"
                                                                target="_blank" href="{{ asset($revData->doc_name) }}"><i
                                                                    class="fa fa-eye text-success"></i>{{ __('messages.view_document') }}</a>
                                                        </span>
                                                    @endif
                                                    @if ($revData->updated_img != null)
                                                        <span class="text-success"> <a style="color:#00A86B !important"
                                                                target="_blank" href="{{ asset($revData->updated_img) }}"><i
                                                                    class="fa fa-eye text-success"></i>{{ __('messages.View_Updated_Profile_Image') }}</a>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            @else
                                <div class="verticle-job-modern">

                                    <div class="verticle-job-top-capt">
                                        <div class="col-md-12 text-center">
                                            @if ($revData->profile_name == null)
                                                <h4 class="m-1">{{ $revData->name }}</h4><br>
                                            @else
                                                <h4 class="m-1">{{ $revData->profile_name }}</h4><br>
                                            @endif
                                        </div>
                                        <div class="vjt-left-cmp">
                                            <div class="vjt-cmp-thumb m-1">
                                                <a href="javascript:function() { return false; }">
                                                    @if ($revData->user_pic != null)
                                                        @if ($revData->self_consent == 1)
                                                            <img src="{{ asset($revData->user_pic) }}" alt="user image" />
                                                        @else
                                                            @if ($revData->show_realname == 1)
                                                                <img src="{{ asset($revData->user_pic) }}"
                                                                    alt="user image" />
                                                            @else
                                                                @if ($revData->avatar_pic != null)
                                                                    <img src="{{ asset($revData->avatar_pic) }}"
                                                                        alt="user image" />
                                                                @else
                                                                    <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                                        alt="user image" />
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @else
                                                        <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                            alt="user image" />
                                                    @endif
                                                    {{-- @if ($revData->user_pic != null)
                                                            <img src="{{ asset($revData->user_pic) }}" alt="user image" />
                                                        @else
                                                            <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                                alt="user image" />
                                                        @endif --}}
                                                </a>
                                            </div>
                                            <span class="float-right">
                                                @if ($revData->star_ratings == '-1')
                                                    <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                                @endif
                                                @if ($revData->star_ratings == '-2')
                                                    <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                                @endif
                                                @if ($revData->star_ratings == '-3')
                                                    <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                                @endif
                                                @if ($revData->star_ratings == '-4')
                                                    <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                                @endif
                                                @if ($revData->star_ratings == '-5')
                                                    <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                                @endif

                                                @if ($revData->star_ratings == '1')
                                                    <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                @endif
                                                @if ($revData->star_ratings == '2')
                                                    <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                @endif
                                                @if ($revData->star_ratings == '3')
                                                    <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                @endif
                                                @if ($revData->star_ratings == '4')
                                                    <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                @endif
                                                @if ($revData->star_ratings == '5')
                                                    <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                @endif

                                                {{-- @if ($revData->user_id == Session::get('login_user_id'))
                                                    <i style="cursor: pointer;" class="fa fa-edit fa-lg mr-3"
                                                        onclick="editReviewViewLoad('{{ $revData->id }}')"
                                                        aria-hidden="true"></i>
                                                    <i style="cursor: pointer;" class="fa fa-trash fa-lg"
                                                        onclick="removeReview('{{ $revData->id }}')" aria-hidden="true"></i>
                                                @endif --}}
                                            </span>
                                            <div class="vjt-cmp-title">
                                                @if ($revData->self_consent != 1)
                                                    @if ($revData->nick != null)
                                                        @if ($revData->show_realname == 1)
                                                            <h4 class="jmg-title">{{ $revData->name }} {{ $revData->lname }}
                                                            </h4>
                                                        @else
                                                            <h4 class="jmg-title">{{ $revData->nick }}</h4>
                                                        @endif
                                                    @else
                                                        <h4 class="jmg-title">{{ $revData->name }} {{ $revData->lname }}</h4>
                                                    @endif
                                                @else
                                                    <h4 class="jmg-title">{{ $revData->name }} {{ $revData->lname }}</h4>
                                                @endif
                                                {{-- @if ($revData->nickname != null)
                                                    <h4 class="jmg-title">{{ $revData->nickname }}</h4>
                                                @else
                                                    <h4 class="jmg-title">{{ $revData->name }}</h4>
                                                @endif --}}
                                                @if (Session::get('locale') == 'en')
                                                    <span class="category_title"><b>{{ __('messages.category') }}:</b>
                                                        {{ $revData->category_title }},
                                                        <b>{{ __('messages.subcategory') }}:</b>
                                                        {{ $revData->sub_category_title }}</span><br>
                                                @else
                                                    <span class="category_title"><b>{{ __('messages.category') }}:</b>
                                                        {{ $revData->es_category_title }},
                                                        <b>{{ __('messages.subcategory') }}:</b>
                                                        {{ $revData->es_sub_category_title }}</span><br>
                                                @endif

                                                <span class="rating-review mt-1">
                                                    {{-- {{ $revData->star_ratings }} --}}
                                                    @if ($revData->star_ratings == '-1')
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '-2')
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '-3')
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '-4')
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '-5')
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                        <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                            style="color: #ff4545"></i>
                                                    @endif

                                                    @if ($revData->star_ratings == '1')
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '2')
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '3')
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '4')
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                    @endif
                                                    @if ($revData->star_ratings == '5')
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                            style="color: #ffa534"></i>
                                                    @endif
                                                    {{-- @if ($revData->star_ratings == '0')
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    @endif --}}
                                                </span>

                                                {{-- <h6 class="vjt-company-title"><a href="#">Dribbble</a></h6> --}}
                                            </div>
                                        </div>
                                        <div class="vjt-right-cmp">
                                            {{-- <h4 class="jmg-sallery">$1200 - $1500 PLN</h4> --}}
                                        </div>
                                    </div>

                                    <div class="verticle-job-bottom-capt">
                                        <div class="vjt-skills">
                                            <div class="tr-single-body">
                                                <p>
                                                    {{ $revData->review_description }}
                                                </p>
                                            </div>
                                            {{-- <span class="skl">Web Design</span><span class="skl">PHP</span><span class="skl">3 more</span> --}}

                                            <div class="vjt-metainfo">
                                                <span><i class="ti-location-pin"></i>{{ $revData->user_country }}</span>
                                                {{-- <span><i class="ti-briefcase"></i>Full Time</span> --}}
                                                <span><i class="ti-calendar"></i>{{ __('messages.Post_Date') }}:
                                                    {{ $revData->post_date }}</span>
                                                @if ($revData->type == 'Commendation')
                                                    <span><i class="ti-calendar"></i>{{ __('messages.Review_Type') }}:
                                                        {{ __('messages.Commendation') }}</span>
                                                @else
                                                    <span><i class="ti-calendar"></i>{{ __('messages.Review_Type') }}:
                                                        {{ __('messages.Complaint') }}</span>
                                                @endif
                                                @if ($revData->self_consent == 1)
                                                    <span>{{ __('messages.Verified_Review') }} <i class="fa fa-check mr-0"
                                                            aria-hidden="true"></i><i class="fa fa-check"
                                                            aria-hidden="true"></i></span>
                                                @else
                                                    <span>{{ __('messages.Unverified_Review') }}</span>
                                                @endif
                                                @if ($revData->doc_name != null)
                                                    <span class="text-success"> <a style="color:#00A86B !important"
                                                            target="_blank" href="{{ asset($revData->doc_name) }}"><i
                                                                class="fa fa-eye text-success"></i>{{ __('messages.view_document') }}</a>
                                                    </span>
                                                @endif
                                                @if ($revData->updated_img != null)
                                                    <span class="text-success"> <a style="color:#00A86B !important"
                                                            target="_blank" href="{{ asset($revData->updated_img) }}"><i
                                                                class="fa fa-eye text-success"></i>{{ __('messages.View_Updated_Profile_Image') }}</a>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </section>

    @if (empty(Session::get('login_username')))
        <section class="pt-0">
            <div class="container text-center">
                <a href="{{ route('user_login_page') }}" class="btn btn-md btn-outline-info btn-rounded mb-3">{{ __('messages.view_more') }}</a>
            </div>
        </section>
    @endif
    <div class="clearfix"></div>
    <!-- ============================ Popular Reviews End ================================== -->

    

    <!-- ============================ Category Start ================================== -->
    {{-- <!--section class="gray">
        <div class="container">

            <div class="row">
                <div class="col text-center">
                    <div class="sec-heading mx-auto">
                        <p>{{ __('messages.browse_review_profiles_by_category') }}</p>
                        <h2>{{ __('messages.popular_categories') }}</h2>
                    </div>
                </div>
            </div>            

            <div class="row">
                <ul class="category-wrap">
                    @if (isset($data['mostCategories']) && $data['mostCategories']->count() > 0)
                        @foreach ($data['mostCategories'] as $mostCat)
                            @if (Session::get('locale') == 'en')
                                @if ($mostCat->id == 16)
                                    @php
                                        $constructionData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 16)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-hummer"></i>
                                            <h4>{{ $mostCat->category_title }}</h4>
                                            <span>{{ $constructionData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 9)
                                    @php
                                        $salesData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 9)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-money"></i>
                                            <h4>{{ $mostCat->category_title }}</h4>
                                            <span>{{ $salesData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 12)
                                    @php
                                        $communicationData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 12)
                                            ->count();
                                    @endphp

                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-headphone-alt"></i>
                                            <h4>{{ $mostCat->category_title }}</h4>
                                            <span>{{ $communicationData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 1)
                                    @php
                                        $healthData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 1)
                                            ->count();
                                    @endphp

                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-heart-broken"></i>
                                            <h4>{{ $mostCat->category_title }}</h4>
                                            <span>{{ $healthData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 4)
                                    @php
                                        $informationData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 4)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-desktop"></i>
                                            <h4>{{ $mostCat->category_title }}</h4>
                                            <span>{{ $informationData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 2)
                                    @php
                                        $educationData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 2)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-book"></i>
                                            <h4>{{ $mostCat->category_title }}</h4>
                                            <span>{{ $educationData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 15)
                                    @php
                                        $transportData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 15)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-car"></i>
                                            <h4>{{ $mostCat->category_title }}</h4>
                                            <span>{{ $transportData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 11)
                                    @php
                                        $financeData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 11)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span href="#" class="standard-category-box">
                                            <i class="ti-gift"></i>
                                            <h4>{{ $mostCat->category_title }}</h4>
                                            <span>{{ $financeData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif
                            @else
                                @if ($mostCat->id == 16)
                                    @php
                                        $constructionData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 16)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-hummer"></i>
                                            <h4>{{ $mostCat->es_category_title }}</h4>
                                            <span>{{ $constructionData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 9)
                                    @php
                                        $salesData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 9)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-money"></i>
                                            <h4>{{ $mostCat->es_category_title }}</h4>
                                            <span>{{ $salesData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 12)
                                    @php
                                        $communicationData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 12)
                                            ->count();
                                    @endphp

                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-headphone-alt"></i>
                                            <h4>{{ $mostCat->es_category_title }}</h4>
                                            <span>{{ $communicationData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 1)
                                    @php
                                        $healthData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 1)
                                            ->count();
                                    @endphp

                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-heart-broken"></i>
                                            <h4>{{ $mostCat->es_category_title }}</h4>
                                            <span>{{ $healthData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 4)
                                    @php
                                        $informationData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 4)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-desktop"></i>
                                            <h4>{{ $mostCat->es_category_title }}</h4>
                                            <span>{{ $informationData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 2)
                                    @php
                                        $educationData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 2)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-book"></i>
                                            <h4>{{ $mostCat->es_category_title }}</h4>
                                            <span>{{ $educationData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 15)
                                    @php
                                        $transportData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 15)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-car"></i>
                                            <h4>{{ $mostCat->es_category_title }}</h4>
                                            <span>{{ $transportData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif

                                @if ($mostCat->id == 11)
                                    @php
                                        $financeData = \App\Models\Profile::where('is_delete', 0)
                                            ->where('category_id', 11)
                                            ->count();
                                    @endphp
                                    <li>
                                        <span class="standard-category-box">
                                            <i class="ti-gift"></i>
                                            <h4>{{ $mostCat->es_category_title }}</h4>
                                            <span>{{ $financeData }} {{ __('messages.profiles') }}</span>
                                        </span>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    @endif

                </ul>

            </div>

        </div>
    </section> --}}
    <div class="clearfix"></div>
    <!-- ============================ Category End ================================== -->

   

    <!-- ============================ Popular Reviews Start ================================== -->
    {{-- <!--section>
        <div class="container">

            <div class="row">
                <div class="col text-center">
                    <div class="sec-heading mx-auto">
                        <p>{{ __('messages.check_the_most_commended') }}</p>
                        <h2>{{ __('messages.top_ten_most') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if (isset($data['reviewsData']) && $data['reviewsData']->count() > 0)
                        @foreach ($data['reviewsData'] as $revData)
                            <div class="verticle-job-modern">

                                <div class="verticle-job-top-capt">
                                    <div class="col-md-12 text-center">
                                        @if ($revData->profile_name == null)
                                            <h4 class="m-1"><a href="#">{{ $revData->name }}</a></h4><br>
                                        @else
                                            <h4 class="m-1"><a href="#">{{ $revData->profile_name }}</a>
                                            </h4><br>
                                        @endif
                                    </div>
                                    <div class="vjt-left-cmp">
                                        <div class="vjt-cmp-thumb m-1">
                                            <a href="#">
                                                @if ($revData->user_pic != null)
                                                    @if ($revData->self_consent == 1)
                                                        <img src="{{ asset($revData->user_pic) }}" alt="user image" />
                                                    @else
                                                        @if ($revData->show_realname == 1)
                                                            <img src="{{ asset($revData->user_pic) }}"
                                                                alt="user image" />
                                                        @else
                                                            @if ($revData->avatar_pic != null)
                                                                <img src="{{ asset($revData->avatar_pic) }}"
                                                                    alt="user image" />
                                                            @else
                                                                <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                                    alt="user image" />
                                                            @endif
                                                        @endif
                                                    @endif
                                                @else
                                                    <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                        alt="user image" />
                                                @endif                                                
                                            </a>
                                        </div>
                                        <span class="float-right">
                                            @if ($revData->star_ratings == '-1')
                                                <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                            @endif
                                            @if ($revData->star_ratings == '-2')
                                                <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                            @endif
                                            @if ($revData->star_ratings == '-3')
                                                <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                            @endif
                                            @if ($revData->star_ratings == '-4')
                                                <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                            @endif
                                            @if ($revData->star_ratings == '-5')
                                                <i class="fa fa-thumbs-down fa-lg mr-3" style="color:red"></i>
                                            @endif

                                            @if ($revData->star_ratings == '1')
                                                <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                    style="color: #ffa534"></i>
                                            @endif
                                            @if ($revData->star_ratings == '2')
                                                <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                    style="color: #ffa534"></i>
                                            @endif
                                            @if ($revData->star_ratings == '3')
                                                <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                    style="color: #ffa534"></i>
                                            @endif
                                            @if ($revData->star_ratings == '4')
                                                <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                    style="color: #ffa534"></i>
                                            @endif
                                            @if ($revData->star_ratings == '5')
                                                <i class="fa fa-thumbs-up fa-lg mr-3" aria-hidden="true"
                                                    style="color: #ffa534"></i>
                                            @endif
                                           
                                        </span>
                                        <div class="vjt-cmp-title">
                                            @if ($revData->self_consent != 1)
                                                @if ($revData->nick != null)
                                                    @if ($revData->show_realname == 1)
                                                        <h4 class="jmg-title">{{ $revData->name }} {{ $revData->lname }}
                                                        </h4>
                                                    @else
                                                        <h4 class="jmg-title">{{ $revData->nick }}</h4>
                                                    @endif
                                                @else
                                                    <h4 class="jmg-title">{{ $revData->name }} {{ $revData->lname }}</h4>
                                                @endif
                                            @else
                                                <h4 class="jmg-title">{{ $revData->name }} {{ $revData->lname }}</h4>
                                            @endif
                                           
                                            @if (Session::get('locale') == 'en')
                                                <span class="category_title"><b>{{ __('messages.category') }}:</b>
                                                    {{ $revData->category_title }},
                                                    <b>{{ __('messages.subcategory') }}:</b>
                                                    {{ $revData->sub_category_title }}</span><br>
                                            @else
                                                <span class="category_title"><b>{{ __('messages.category') }}:</b>
                                                    {{ $revData->es_category_title }},
                                                    <b>{{ __('messages.subcategory') }}:</b>
                                                    {{ $revData->es_sub_category_title }}</span><br>
                                            @endif

                                            <span class="rating-review mt-1">                                              
                                                @if ($revData->star_ratings == '-1')
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                @endif
                                                @if ($revData->star_ratings == '-2')
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                @endif
                                                @if ($revData->star_ratings == '-3')
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                @endif
                                                @if ($revData->star_ratings == '-4')
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                @endif
                                                @if ($revData->star_ratings == '-5')
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                    <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"
                                                        style="color: #ff4545"></i>
                                                @endif

                                                @if ($revData->star_ratings == '1')
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                @endif
                                                @if ($revData->star_ratings == '2')
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                @endif
                                                @if ($revData->star_ratings == '3')
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                @endif
                                                @if ($revData->star_ratings == '4')
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                @endif
                                                @if ($revData->star_ratings == '5')
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"
                                                        style="color: #ffa534"></i>
                                                @endif
                                                
                                            </span>

                                           
                                        </div>
                                    </div>
                                    <div class="vjt-right-cmp">
                                       
                                    </div>
                                </div>

                                <div class="verticle-job-bottom-capt">
                                    <div class="vjt-skills">
                                        <div class="tr-single-body">
                                            <p>
                                                {{ $revData->review_description }}
                                            </p>
                                        </div>
                                       

                                        <div class="vjt-metainfo">
                                            <span><i class="ti-location-pin"></i>{{ $revData->user_country }}</span>
                                           
                                            <span><i class="ti-calendar"></i>{{ __('messages.Post_Date') }}:
                                                {{ $revData->post_date }}</span>
                                            @if ($revData->type == 'Commendation')
                                                <span><i class="ti-calendar"></i>{{ __('messages.Review_Type') }}:
                                                    {{ __('messages.Commendation') }}</span>
                                            @else
                                                <span><i class="ti-calendar"></i>{{ __('messages.Review_Type') }}:
                                                    {{ __('messages.Complaint') }}</span>
                                            @endif
                                            @if ($revData->self_consent == 1)
                                                <span>{{ __('messages.Verified_Review') }} <i class="fa fa-check mr-0"
                                                        aria-hidden="true"></i><i class="fa fa-check"
                                                        aria-hidden="true"></i></span>
                                            @else
                                                <span>{{ __('messages.Unverified_Review') }}</span>
                                            @endif
                                            @if ($revData->doc_name != null)
                                                <span class="text-success"> <a style="color:#00A86B !important"
                                                        target="_blank" href="{{ asset($revData->doc_name) }}"><i
                                                            class="fa fa-eye text-success"></i>{{ __('messages.view_document') }}</a>
                                                </span>
                                            @endif
                                            @if ($revData->updated_img != null)
                                                <span class="text-success"> <a style="color:#00A86B !important"
                                                        target="_blank" href="{{ asset($revData->updated_img) }}"><i
                                                            class="fa fa-eye text-success"></i>{{ __('messages.View_Updated_Profile_Image') }}</a>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </section> --}}

    {{-- @if (empty(Session::get('login_username')))
        <section class="pt-0">
            <div class="container text-center">
                <a href="{{ route('user_login_page') }}" class="btn btn-md btn-outline-info btn-rounded mb-3">{{ __('messages.view_more') }}</a>
            </div>
        </section>
    @endif --}}
    <div class="clearfix"></div>
    <!-- ============================ Popular Reviews End ================================== -->

    <!-- ============================ Testimonial  Start================================== -->
    <!--section class="image-bg text-center"
        style="background: url({{ asset('frontend/assets/img/home_page_bg_one.jpg') }});" data-overlay="8">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10">
                    <div class="owl-carousel testimonial-3" id="testimonial-3-slide">

                        @if (isset($data['reviewsDataTestimonial']) && $data['reviewsDataTestimonial']->count() > 0)
                            @foreach ($data['reviewsDataTestimonial'] as $reviewsDetails)
                                <!-- Single Testimonial -->
                                <!--div class="item">
                                    <div class="tauth-thumb">
                                        @if ($reviewsDetails->user_pic != null)
                                            <img class="mx-auto img-circle" style="width: 110px;height: 110px;"
                                                src="{{ asset($reviewsDetails->user_pic) }}" alt="user image" />
                                        @else
                                            <img class="mx-auto img-circle"
                                                src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                style="width: 110px;height: 110px;" alt="user image" />
                                        @endif
                                    </div>
                                    <div class="tauth-detail">
                                        <h4 class="tauth-title">{{ $reviewsDetails->name }}</h4>
                                        @if (Session::get('locale') == 'en')
                                            <span class="tauth-subtitle"><b>{{ __('messages.category') }}:</b>
                                                {{ $reviewsDetails->category_title }},
                                                <b>{{ __('messages.subcategory') }}:</b>
                                                {{ $reviewsDetails->sub_category_title }}</span>
                                        @else
                                            <span class="tauth-subtitle"><b>{{ __('messages.category') }}:</b>
                                                {{ $reviewsDetails->es_category_title }},
                                                <b>{{ __('messages.subcategory') }}:</b>
                                                {{ $reviewsDetails->es_sub_category_title }}</span>
                                        @endif
                                        <p
                                            style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 4;line-clamp: 4; -webkit-box-orient: vertical;">
                                            {{ $reviewsDetails->review_description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Testimonial End ================================== -->

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
                                                    <h4 class="cnt-gb-title"><a
                                                            href="#">{{ $customAd->heading }}</a>
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

    <!-- ============================ Newsletter Start ================================== -->
    <section class="alert-wrap pt-5 pb-5 d-none"
        style="background: #00a94f url({{ asset('frontend/assets/img/bg2.png') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="jobalert-sec">
                        <h3 class="mb-1 text-light">Get New Jobs Notification!</h3>
                        <p class="text-light">Subscribe & get all related jobs notification.</p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter Your Email">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-black black">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Newsletter Start ================================== -->
    {{-- <section class="googleads">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7530338136287640"
            crossorigin="anonymous"></script>
    </section> --}}
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

        $(".clearFilter").click(function(ev) {
            // location.reload();  
            $("#category").val('').trigger('change');
            $("#subcate").val('').trigger('change');
            $("#address-input").val('');
            $("#profile_name").val('');
            //hide list   
            $('.popularList').addClass('d-none');
            // show slider
            $('.mostPopular').removeClass('d-none');
        });

        $('#category').select2({
            placeholder: "{{ __('messages.choose_a_category') }}",
            allowClear: true
        });

        $('#subcate').select2({
            placeholder: "{{ __('messages.choose_a_subcategory') }}",
            allowClear: true,
            formatNoMatches: function() {
                return "Nothing found";
            },
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
                        $('.popularList').removeClass('d-none');
                        // hide slider
                        $('.mostPopular').addClass('d-none');
                        $('#mostPopularlist').html(data);
                        $('html, body').animate({
                            scrollTop: $(".popularList").offset().top - 150
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
                    // error please select category subcategory and location                    
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
