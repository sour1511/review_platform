<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('login')->middleware('prevent-back-history');;
// });

// for testing multi language
Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

// for frontend main website routes
Route::get('/', [FrontendController::class, 'home'])->name('home')->middleware('prevent-back-history');
Route::get('browse/profiles', [FrontendController::class, 'browseProfiles'])->name('browse_profiles');
Route::get('contact', [FrontendController::class, 'contactUs'])->name('contact');
Route::get('profile/details', [FrontendController::class, 'profileDetails'])->name('profiledetails');
Route::post('submit/review', [FrontendController::class, 'submitReview'])->name('submit_review')->middleware('frontend.auth');
Route::get('getprofiles', [FrontendController::class, 'browseProfileFilterAjaxCall'])->name('getprofilesfilter');
Route::post('api/fetchCategory', [FrontendController::class, 'fetchCategory']);
Route::post('api/fetchSubCategory', [FrontendController::class, 'fetchSubCategory']);
Route::get('getreviews', [FrontendController::class, 'profileReviewFilterAjaxCall'])->name('getreviews');
Route::post('register_reviewprofile', [FrontendController::class, 'register_reviewprofile'])->name('register_reviewprofile')->middleware('frontend.auth');
Route::post('user/delete_review', [FrontendController::class, 'removeReview'])->name('remove_review')->middleware('frontend.auth');
Route::post('getreviews_view', [FrontendController::class, 'getReviewUpdateView'])->name('getreviewsview')->middleware('frontend.auth');
Route::post('updatereview', [FrontendController::class, 'updateReview'])->name('updatereview')->middleware('frontend.auth');
Route::get('mostpopularprofiles', [FrontendController::class, 'getMostPopularProfiles'])->name('mostpopularprofiles');
Route::post('contact/email', [FrontendController::class, 'sendContactEmail'])->name('contactemail')->middleware('throttle:10,1');
Route::get('terms_and_conditions', [FrontendController::class, 'termsAndConditions'])->name('terms_and_conditions');
Route::get('privacy_policy', [FrontendController::class, 'privacyPolicy'])->name('privacy_policy');

Route::post('user/set_current_time', [FrontendController::class, 'setCurrentTimeSession'])->name('set_currenttime_user');
Route::get('get_country', [FrontendController::class, 'getCountry'])->name('get_country');
// Password reset
Route::post('send/forget_request', [FrontendController::class, 'forgetPasswordRequest'])->name('forget_request')->middleware('throttle:5,1');
Route::get('user/set_password/{token}', [FrontendController::class, 'setPasswordView'])->name('set_password')->middleware('prevent-back-history');
Route::post('user/update_password', [FrontendController::class, 'updatePassword'])->name('update_password')->middleware('throttle:5,1');

Route::get('create/review_profile', [FrontendController::class, 'review_profile'])->name('review_profile')->middleware('frontend.auth');
Route::get('user_logout', [FrontendController::class, 'logout'])->name('user_logout')->middleware('prevent-back-history');
Route::get('user/login', [FrontendController::class, 'userLoginPage'])->name('user_login_page')->middleware('prevent-back-history');
Route::post('user_Login', [FrontendController::class, 'user_Login'])->name('user_Login')->middleware('throttle:10,1');
Route::post('register', [FrontendController::class, 'register'])->name('register')->middleware('throttle:10,1');
Route::post('get_subcategories', [FrontendController::class, 'getSubcategory'])->name('getsubcategory');
Route::post('userprofileupdate', [FrontendController::class, 'userProfileUpdate'])->name('userprofileupdate')->middleware('frontend.auth');
// category create — authenticated users only
Route::post('newcategory', [FrontendController::class, 'createNewCatgoryAndSubcategory'])->name('newcategory')->middleware('frontend.auth');
Route::post('newsubcategory', [FrontendController::class, 'createNewSubcategory'])->name('newsubcategory')->middleware('frontend.auth');

// for admin panel
Route::get('admin/login', [AdminController::class, 'login'])->name('login')->middleware('prevent-back-history');
Route::get('logout', [AdminController::class, 'logout'])->name('logout')->middleware('prevent-back-history');
Route::post('userLogin', [AdminController::class, 'userLogin'])->name('userLogin')->middleware('throttle:10,1');
Route::post('user/set_current_lang', [FrontendController::class, 'setCurrentLanguage'])->name('set_current_lang');


// route for admin
Route::group(['middleware' => ['isAdmin']], function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware('prevent-back-history');
    Route::get('admin/reviews', [AdminController::class, 'reviewsListView'])->name('reviews')->middleware('prevent-back-history');

    Route::get('admin/users', [AdminController::class, 'usersList'])->name('userslist')->middleware('prevent-back-history');
    Route::post('admin/user/delete', [AdminController::class, 'deleteUser'])->name('deleteuser');
    Route::get('admin/user/edit', [AdminController::class, 'userEditView'])->name('useredit');
    Route::post('admin/user/update', [AdminController::class, 'userUpdate'])->name('userupdate');

    Route::get('admin/reviews/edit', [AdminController::class, 'reviewsEditView'])->name('reviewsedit');
    Route::post('admin/reviews/delete', [AdminController::class, 'reviewDelete'])->name('reviewdelete');
    Route::post('admin/reviews/update', [AdminController::class, 'reviewUpdate'])->name('reviewupdate');
    Route::get('admin/autocompletecategory', [AdminController::class, 'autocompleteCategory'])->name('autocompletecategory');
    Route::get('admin/get_reviewslist', [AdminController::class, 'reviewsListAjax'])->name('getreviewslist');
    Route::post('admin/update_profile', [AdminController::class, 'update_user_profile'])->name('updateuserprofile');
    Route::get('admin/review_profiles', [AdminController::class, 'reviewProfiles'])->name('review_profiles');
    Route::get('admin/get_reviewprofileslist', [AdminController::class, 'reviewProfilesListAjax'])->name('getreviewprofileslist');
    Route::get('admin/profile_details', [AdminController::class, 'profileDetailsView'])->name('adminprofiledetailsview');
    Route::post('admin/get_subcategories', [AdminController::class, 'getSubcategory'])->name('getsubcategoryadmin');
    Route::get('admin/getreviewsall', [AdminController::class, 'profileReviewFilterAjaxCall'])->name('getreviewsadmin');
    Route::post('admin/profile/delete', [AdminController::class, 'profileDelete'])->name('profiledelete');
    // ads settings
    Route::get('admin/ads/settings', [AdminController::class, 'adsSettings'])->name('adssettingsview');
    Route::post('admin/ads/add', [AdminController::class, 'adsAdd'])->name('add_ads');
    Route::get('admin/hide/ads', [AdminController::class, 'hideAdsHome'])->name('hide_ads');
    Route::get('admin/ads/list', [AdminController::class, 'adsList'])->name('adslist');
    Route::post('admin/ads/delete', [AdminController::class, 'deleteAd'])->name('deletead');
    Route::post('admin/get/ad', [AdminController::class, 'getAdUpdateView'])->name('getadview');
    Route::post('admin/updatead', [AdminController::class, 'updateAd'])->name('updatead');
    Route::get('admin/category/list', [AdminController::class, 'categoryList'])->name('categorylists');
    Route::post('admin/get/category', [AdminController::class, 'getCategoryView'])->name('getcategoryview');
    Route::post('admin/update/category', [AdminController::class, 'updateCategory'])->name('updatecategory');
    Route::get('admin/subcategory/list', [AdminController::class, 'subcategoryList'])->name('subcategorylists');
    Route::post('admin/get/subcategory', [AdminController::class, 'getSubCategoryView'])->name('getsubcategoryview');
    Route::post('admin/update/subcategory', [AdminController::class, 'updateSubCategory'])->name('updatesubcategory');
    Route::post('admin/category/delete', [AdminController::class, 'deleteCategory'])->name('delete_category');
    Route::post('admin/subcategory/delete', [AdminController::class, 'deleteSubcategory'])->name('delete_subcategory');
});
