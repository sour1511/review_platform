@php
    use Carbon\Carbon;
@endphp
<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            @if (isset($data['reviewData']) && $data['reviewData']->count() > 0)
                @foreach ($data['reviewData'] as $revData)
                    <!-- Single Job List -->
                    <div class="verticle-job-modern">
                        <div class="verticle-job-top-capt">
                            <div class="vjt-left-cmp">
                                <div class="vjt-cmp-thumb m-1">
                                    <a href="#">
                                        @if ($revData->user_pic != null)
                                            @if ($revData->self_consent == 1)
                                                <img src="{{ asset($revData->user_pic) }}" alt="user image" />
                                            @else
                                                @if ($revData->show_realname == 1)
                                                    <img src="{{ asset($revData->user_pic) }}" alt="user image" />
                                                @else
                                                    @if ($revData->avatar_pic != null)
                                                        <img src="{{ asset($revData->avatar_pic) }}" alt="user image" />
                                                    @else
                                                        <img src="{{ asset('frontend/assets/img/avatar.jpg') }}"
                                                            alt="user image" />
                                                    @endif
                                                @endif
                                            @endif
                                        @else
                                            <img src="{{ asset('frontend/assets/img/avatar.jpg') }}" alt="user image" />
                                        @endif
                                    </a>
                                </div>
                                <span class="float-right">
                                    {{-- @php
                                        $posted_date = new Carbon($revData->post_date . ' ' . $revData->post_time);
                                        $is_expired = $posted_date->addMinutes(30);
                                    @endphp --}}
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

                                    @if ($revData->user_id == Session::get('login_user_id'))
                                        <i style="cursor: pointer;" class="fa fa-edit fa-lg mr-3"
                                            onclick="editReviewViewLoad('{{ $revData->id }}')" aria-hidden="true"></i>
                                        <i style="cursor: pointer;" class="fa fa-trash fa-lg"
                                            onclick="removeReview('{{ $revData->id }}')" aria-hidden="true"></i>
                                    @endif
                                </span>
                                <div class="vjt-cmp-title">
                                    @if ($revData->self_consent != 1)
                                        @if ($revData->nick != null)
                                            @if ($revData->show_realname == 1)
                                                <h4 class="jmg-title">{{ $revData->name }} {{ $revData->lname }}</h4>
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
                                        <span><b>{{ __('messages.category') }}:</b>
                                            {{ $data['profilesData']->category_title }},
                                            <b>{{ __('messages.subcategory') }}:</b>
                                            {{ $data['profilesData']->sub_category_title }}</span><br>
                                    @else
                                        <span><b>{{ __('messages.category') }}:</b>
                                            {{ $data['profilesData']->es_category_title }},
                                            <b>{{ __('messages.subcategory') }}:</b>
                                            {{ $data['profilesData']->es_sub_category_title }}</span><br>
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
                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
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
                                        <span> <a style="color:#00A86B !important" target="_blank"
                                                href="{{ asset($revData->doc_name) }}"><i
                                                    class="fa fa-eye text-success"></i>{{ __('messages.view_document') }}</a>
                                        </span>
                                    @endif
                                    @if ($revData->updated_img != null)
                                        <span> <a style="color:#00A86B !important" target="_blank"
                                                href="{{ asset($revData->updated_img) }}"><i
                                                    class="fa fa-eye text-success"></i>{{ __('messages.View_Updated_Profile_Image') }}</a>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="vjt-metainfo">
                                <span><i class="ti-location-pin"></i>Canada</span>
                                <span><i class="ti-briefcase"></i>Full Time</span>
                                <span><i class="ti-calendar"></i>Jan 10, 2020</span>
                            </div> --}}
                        </div>

                    </div>
                @endforeach
            @else
                <div class="col-lg-12 col-xl-12 mb-3 text-center">
                    <h4>{{ __('messages.No_reviews_found') }}</h4>
                </div>
            @endif

        </div>
    </div>
    {{-- pagination --}}
    @if (!empty(Session::get('login_username')))
        {!! $data['reviewData']->links('vendor.pagination.customcopy') !!}
    @endif
    {{-- pagination end --}}
</div>
@if (empty(Session::get('login_username')))
    @if (isset($data['reviewData']) && $data['reviewData']->count() != 0)
        <section class="p-0 mt-3">
            <div class="container text-center">
                <button class="btn btn-md btn-outline-info mb-3" data-toggle="modal"
                    data-target="#login">{{ __('messages.view_more') }}</button>
            </div>
        </section>
    @endif
@endif
