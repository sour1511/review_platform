<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Review;
use App\Models\Profile;
use App\Models\Category;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{
    public function addReview(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_id' => 'required|integer',
                'review_description' => 'required|string|max:10000',
                'user_name' => 'required|string|max:250',
                'user_country' => 'required|string|max:250',
                'post_date' => 'required|date',
                'user_id' => 'nullable|integer',
                'user_email' => 'nullable|email',
                'star_ratings' => 'nullable|numeric',
                'sub_category_id' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $reviewData = new Review;
            $reviewData->sub_category_id = $request->sub_category_id;
            $reviewData->star_ratings = $request->star_ratings;
            // Never trust client self_consent as "verified"
            $reviewData->self_consent = 0;
            $reviewData->user_id = $request->user_id;
            $reviewData->user_email = $request->user_email;
            $reviewData->user_mobile = $request->user_mobile;
            $reviewData->user_address = $request->user_address;
            $reviewData->user_state = $request->user_state;
            $reviewData->category_id = $request->category_id;
            $reviewData->post_date = $request->post_date;
            $reviewData->review_description = $request->review_description;
            $reviewData->user_name = $request->user_name;
            $reviewData->user_country = $request->user_country;

            if ($reviewData->save()) {
                return response()->json(['status' => 'success', 'message' => 'review save']);
            }

            return response()->json(['status' => 'failure', 'message' => 'review not save'], 500);
        } catch (Exception $e) {
            Log::error('API addReview failed: ' . $e->getMessage());
            return response()->json(['status' => 'failure', 'message' => 'Server error'], 500);
        }
    }

    public function getAllVerifiedReviews()
    {
        $reviews = Review::where('self_consent', 1)->orderBy('id', 'DESC')->paginate(20);
        if ($reviews->isNotEmpty()) {
            return response()->json([
                'status' => 'success',
                'data' => $reviews,
                'total_page' => $reviews->lastPage(),
            ]);
        }

        return response()->json(['status' => 'failure', 'message' => 'No reviews found']);
    }

    public function getSearchCategoryByName(Request $request)
    {
        $search = (string) $request->input('search', '');
        $category = DB::table('categories')->select('categories.id')
            ->where('categories.is_delete', 0)
            ->where('categories.status', 0)
            ->where(function ($query) use ($search) {
                $query->where('categories.category_title', 'LIKE', '%' . addcslashes($search, '%_\\') . '%');
            })
            ->get();

        return response()->json($category);
    }

    public function getSearchCategoryById(Request $request)
    {
        $category_ids = array_filter(array_map('intval', explode(',', (string) $request->search)));
        $reviews = Review::where('self_consent', 1)->whereIn('category_id', $category_ids)->orderBy('id', 'DESC')->paginate(20);
        if ($reviews->isNotEmpty()) {
            return response()->json([
                'status' => 'success',
                'data' => $reviews,
                'total_page' => $reviews->lastPage(),
            ]);
        }

        return response()->json(['status' => 'failure', 'message' => 'No reviews found']);
    }

    public function createProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_id' => 'required|integer',
                'sub_category_id' => 'nullable|integer',
                'subject_name' => 'required|string|max:250',
                'location' => 'nullable|string|max:500',
                'user_id' => 'required|integer',
                'user_email' => 'nullable|email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $profileData = new Profile;
            $profileData->category_id = $request->category_id;
            $profileData->sub_category_id = $request->sub_category_id;
            $profileData->subject_name = $request->subject_name;
            $profileData->location = $request->location;
            $profileData->user_id = $request->user_id;
            $profileData->user_email = $request->user_email;

            if ($profileData->save()) {
                return response()->json(['status' => 'success', 'message' => 'Profile created']);
            }

            return response()->json(['status' => 'failure', 'message' => 'Profile not created'], 500);
        } catch (Exception $e) {
            Log::error('API createProfile failed: ' . $e->getMessage());
            return response()->json(['status' => 'failure', 'message' => 'Server error'], 500);
        }
    }
}
