<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Protected by api.key middleware. Set API_ACCESS_KEY in .env and send
| header: X-Api-Key: <key>
|
*/

Route::middleware(['api.key', 'throttle:60,1'])->group(function () {
    Route::post('addreview', [ApiController::class, 'addReview']);
    Route::get('getreviews', [ApiController::class, 'getAllVerifiedReviews']);
    Route::post('getcategorybyname', [ApiController::class, 'getSearchCategoryByName']);
    Route::post('getcategorybyids', [ApiController::class, 'getSearchCategoryById']);
    Route::post('createprofile', [ApiController::class, 'createProfile']);
});
