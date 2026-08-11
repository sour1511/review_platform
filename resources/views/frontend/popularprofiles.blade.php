@if (isset($data['profilesData']) && $data['profilesData']->count() > 0)
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
                    {{-- <span class="job-type j-full-time">Full Time</span> --}}
                    <div class="job-grid-thumb">
                        <a href="{{ Route('profiledetails', ['id' => $profiledata->id]) }}">
                            @if ($profiledata->profile_pic != null)
                                <img width="80px;" height="80px" src="{{ asset($profiledata->profile_pic) }}"
                                    class="img-fluid mx-auto" alt="user image" />
                            @else
                                <img src="{{ asset('frontend/assets/img/avatar.jpg') }}" class="img-fluid mx-auto"
                                    alt="user image" />
                            @endif
                            {{-- <img src="https://via.placeholder.com/90x90" class="img-fluid mx-auto" alt="" /></a> --}}
                    </div>
                    @if ($profiledata->profile_name == null)
                        <h4 class="job-title mt-1"><a href="#">{{ $profiledata->name }}</a></h4>
                    @else
                        <h4 class="job-title mt-1"><a href="#">{{ $profiledata->profile_name }}</a></h4>
                    @endif
                    {{-- <h4 class="job-title mt-1"><a href="job-detail.html">{{ $profiledata->profile_name }}</a></h4> --}}
                    <hr>
                    <div class="job-grid-detail">
                        @if (Session::get('locale') == 'en')
                            <h4 class="jbc-name" style="font-size: 13px;"><a
                                    href="{{ Route('profiledetails', ['id' => $profiledata->id]) }}"><b>{{ __('messages.category') }}:</b>
                                    {{ $profiledata->category_title }}, <b>{{ __('messages.subcategory') }}:</b>
                                    {{ $profiledata->sub_category_title }}</a></h4>
                        @else
                            <h4 class="jbc-name" style="font-size: 13px;"><a
                                    href="{{ Route('profiledetails', ['id' => $profiledata->id]) }}"><b>{{ __('messages.category') }}:</b>
                                    {{ $profiledata->es_category_title }}, <b>{{ __('messages.subcategory') }}:</b>
                                    {{ $profiledata->es_sub_category_title }}</a></h4>
                        @endif
                        <p><i class="ti-location-pin"></i>{{ $profiledata->location }} </p>
                    </div>
                    {{-- job-grid-footer class remove --}}
                    <div class="text-center">
                        {{-- <h4 class="job-price">$3,254</h4> --}}
                        <a href="{{ Route('profiledetails', ['id' => $profiledata->id]) }}"
                            class="btn btn-md btn-outline-info btn-rounded mb-3">{{ __('messages.view_more') }}</a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endif
