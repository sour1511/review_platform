<div class="row">
    <!-- layout Wrapper -->
    <div class="col-md-12 mb-3">
        <div class="layout-switcher-wrap">
            <div class="layout-switcher-left">
                {{-- @if ($data['profilesData']->count() > 0)
                    {{ $data['profilesData']->count() }} Result Found
                @else
                    0 Result Found
                @endif --}}
                @if (isset($data['profilesData']) && $data['profilesData']->count() > 0)
                    {{ $data['result'] }} {{ __('messages.Result_Found') }}
                @else
                    0 {{ __('messages.Result_Found') }}
                @endif
            </div>
            {{-- <div class="layout-switcher">
                <ul>
                    <li class="active"><a href="search-freelancers.html"><i class="ti-layout-grid3"></i></a>
                    </li>
                    <li><a href="search-freelancers-list.html"><i class="ti-view-list"></i></a></li>
                </ul>
            </div> --}}
        </div>
    </div>
</div>

<div class="row">

    @if (isset($data['profilesData']) && $data['profilesData']->count() > 0)
        @foreach ($data['profilesData'] as $proData)
            <!-- Single Freelancer -->
            @if (Session::get('locale') == 'en')                
                @if ($proData->category_title != null && $proData->sub_category_title != null)
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="freelancer-verticle">

                            {{-- <h5 class="hr_rate"><span class="text-success">$150</span><small>/hr</small></h5> --}}
                            <div class="freelancer-wrap">
                                <div class="freelancer-thumb">
                                    <a href="{{ Route('profiledetails', ['id' => $proData->id]) }}">
                                        @php
                                            // get current profile all reviews
                                            $totalReview = \App\Models\Review::where('reviews.profile_id', $proData->id)
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
                                        <div class="overall-rate">{{ $finalStar }}</div>
                                        @if ($proData->profile_pic != null)
                                            <img src="{{ asset($proData->profile_pic) }}" class="img-fluid mx-auto"
                                                alt="profile image" />
                                        @else
                                            <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                class="img-fluid mx-auto" alt="profile image" />
                                        @endif
                                    </a>
                                </div>

                                <div class="freelancer-caption">
                                    @if ($proData->profile_name == null)
                                        <h5 class="free-name"><a
                                                href="{{ Route('profiledetails', ['id' => $proData->id]) }}">{{ $proData->name }}</a>
                                        </h5>
                                    @else
                                        <h5 class="free-name"><a
                                                href="{{ Route('profiledetails', ['id' => $proData->id]) }}">{{ $proData->profile_name }}</a>
                                        </h5>
                                    @endif
                                    @if (Session::get('locale') == 'en')
                                        <span><b>{{ __('messages.category') }}:</b> {{ $proData->category_title }},
                                            <b>{{ __('messages.subcategory') }}:</b>
                                            {{ $proData->sub_category_title }}</span>
                                    @else
                                        <span><b>{{ __('messages.category') }}:</b> {{ $proData->es_category_title }},
                                            <b>{{ __('messages.subcategory') }}:</b>
                                            {{ $proData->es_sub_category_title }}</span>
                                    @endif
                                    <p class="free-location"><i class="ti-location-pin"></i>{{ $proData->location }}
                                    </p>
                                </div>

                                <div class="freelancer-info">
                                    <ul>
                                        @if ($proData->user_email != null)
                                            <li><i class="ti-email text-warning"></i>{{ $proData->user_email }}</li>
                                        @endif
                                        @if ($proData->mobile_number != null)
                                            <li><i class="ti-mobile text-danger"></i>{{ $proData->mobile_number }}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <div class="freelancer-footer">

                                <div class="job-compelete mb-3"><a class="btn btn-sm btn-primary float-right"
                                        href="{{ Route('profiledetails', ['id' => $proData->id]) }}">{{ __('messages.view_more') }}<i
                                            class="ti-arrow-right ml-1"></i></a></div>
                                <div class="progress">
                                    {{-- <div class="progress-bar progress-bar-striped js-90" role="progressbar" aria-valuenow="90"
                                        aria-valuemin="0" aria-valuemax="100"></div> --}}
                                </div>
                            </div>


                        </div>
                    </div>
                @endif
            @else
                @if ($proData->es_category_title != null && $proData->es_sub_category_title != null)
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="freelancer-verticle">

                            {{-- <h5 class="hr_rate"><span class="text-success">$150</span><small>/hr</small></h5> --}}
                            <div class="freelancer-wrap">
                                <div class="freelancer-thumb">
                                    <a href="{{ Route('profiledetails', ['id' => $proData->id]) }}">
                                        @php
                                            // get current profile all reviews
                                            $totalReview = \App\Models\Review::where('reviews.profile_id', $proData->id)
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
                                        <div class="overall-rate">{{ $finalStar }}</div>
                                        @if ($proData->profile_pic != null)
                                            <img src="{{ asset($proData->profile_pic) }}" class="img-fluid mx-auto"
                                                alt="profile image" />
                                        @else
                                            <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                class="img-fluid mx-auto" alt="profile image" />
                                        @endif
                                    </a>
                                </div>

                                <div class="freelancer-caption">
                                    @if ($proData->profile_name == null)
                                        <h5 class="free-name"><a
                                                href="{{ Route('profiledetails', ['id' => $proData->id]) }}">{{ $proData->name }}</a>
                                        </h5>
                                    @else
                                        <h5 class="free-name"><a
                                                href="{{ Route('profiledetails', ['id' => $proData->id]) }}">{{ $proData->profile_name }}</a>
                                        </h5>
                                    @endif
                                    @if (Session::get('locale') == 'en')
                                        <span><b>{{ __('messages.category') }}:</b> {{ $proData->category_title }},
                                            <b>{{ __('messages.subcategory') }}:</b>
                                            {{ $proData->sub_category_title }}</span>
                                    @else
                                        <span><b>{{ __('messages.category') }}:</b> {{ $proData->es_category_title }},
                                            <b>{{ __('messages.subcategory') }}:</b>
                                            {{ $proData->es_sub_category_title }}</span>
                                    @endif
                                    <p class="free-location"><i class="ti-location-pin"></i>{{ $proData->location }}
                                    </p>
                                </div>

                                <div class="freelancer-info">
                                    <ul>
                                        @if ($proData->user_email != null)
                                            <li><i class="ti-email text-warning"></i>{{ $proData->user_email }}</li>
                                        @endif
                                        @if ($proData->mobile_number != null)
                                            <li><i class="ti-mobile text-danger"></i>{{ $proData->mobile_number }}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <div class="freelancer-footer">

                                <div class="job-compelete mb-3"><a class="btn btn-sm btn-primary float-right"
                                        href="{{ Route('profiledetails', ['id' => $proData->id]) }}">{{ __('messages.view_more') }}<i
                                            class="ti-arrow-right ml-1"></i></a></div>
                                <div class="progress">
                                    {{-- <div class="progress-bar progress-bar-striped js-90" role="progressbar" aria-valuenow="90"
                                    aria-valuemin="0" aria-valuemax="100"></div> --}}
                                </div>
                            </div>


                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    @else
        <div class="col-lg-12 col-xl-12 mb-3 text-center">
            <h4>{{ __('messages.No_data_found') }}</h4>
        </div>
    @endif
</div>
@if (!empty(Session::get('login_username')))
    {!! $data['profilesData']->links('vendor.pagination.customcopy') !!}
@endif

@if (empty(Session::get('login_username')))
    @if (isset($data['profilesData']) && $data['profilesData']->count() != 0)
        <section class="p-0 mt-3">
            <div class="container text-center">
                <button class="btn btn-md btn-outline-info mb-3" data-toggle="modal"
                    data-target="#login">{{ __('messages.view_more') }}</button>
            </div>
        </section>
    @endif
@endif
