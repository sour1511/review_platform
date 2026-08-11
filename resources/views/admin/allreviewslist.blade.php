<table id="reviewsList" class="table table-bordered table-striped mb-3">
    @if (isset($data['reviewsData']) && count($data['reviewsData']) > 0)
        <thead>
            <tr>
                <th>{{ __('messages.date') }}</th>
                <th>{{ __('messages.category') }}</th>
                <th>{{ __('messages.sub_category_name') }}</th>
                <th>{{ __('messages.users_name') }}</th>
                <th>{{ __('messages.review') }}</th>
                <th>{{ __('messages.rating') }}</th>
                <th>{{ __('messages.Type') }}</th>
                <th>{{ __('messages.Is_verified') }}</th>
                <th style="width: 150px !important;">{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['reviewsData'] as $review)
                <tr>
                    <td>{{ $review->post_date }}</td>
                    @php
                        if ($review->category_id != null) {
                            $catData = \App\Models\Category::where('id', $review->category_id)->first();
                            $categoryName = $catData->category_title;
                        } else {
                            $categoryName = 'NULL';
                        }
                        
                        if ($review->sub_category_id != null) {
                            $subcatData = \App\Models\SubCategory::where('id', $review->sub_category_id)->first();
                            $subcategoryName = $subcatData->sub_category_title;
                        } else {
                            $subcategoryName = 'NULL';
                        }
                        
                    @endphp
                    <td>{{ $categoryName }}</td>
                    <td>{{ $subcategoryName }}</td>
                    <td>{{ $review->user_name }}</td>
                    <td>{{ $review->review_description }}</td>

                    @php
                        if ($review->star_ratings == '1' || $review->star_ratings == '-1') {
                            $star = 'Thumb';
                        } else {
                            $star = 'Thumbs';
                        }
                    @endphp
                    <td>{{ $review->star_ratings }} {{ $star }} </td>
                    <td>{{ $review->type }}</td>
                    @php
                        if ($review->self_consent == 1) {
                            $selfConsent = __('messages.verified');
                        } else {
                            $selfConsent = __('messages.not_verified');
                        }
                    @endphp
                    <td>{{ $selfConsent }}</td>
                    <td style="width: 100px;">
                        <div class="col-xs- col-sm-12 col-md-12 col-lg-">
                            <div class="row">
                                <div class="col-xs- col-sm-3 col-md-3 col-lg-">
                                    <a class="btn btn-primary btn-xs" title="{{ __('messages.update') }}"
                                        href="{{ Route('reviewsedit', ['id' => $review->id]) }}"><i
                                            class="fa fa-edit"></i> </a>
                                </div>
                                <div class="col-xs- col-sm-3 col-md-3 col-lg-">
                                    <button type="button" class="btn btn-danger btn-xs scrap"
                                        data-id="<?php echo $review->id; ?>" data-toggle="modal" data-target="#deleteReview"
                                        data-toggle="modal" title="{{ __('messages.delete') }}" style=""><i
                                            class="fa fa-trash"></i> </button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    @else
        <div class="col-lg-12 col-xl-12 mb-3 text-center">
            <h4>{{ __('messages.no_review_found') }}</h4>
        </div>
    @endif
</table>
