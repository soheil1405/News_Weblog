<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return response()->json('heloow');
});
Route::apiResource('/news', NewsController::class);


Route::prefix('comments')->group(function () {

    // this route is for store new comment and also for store answer old comment
    Route::post('/save', [CommentsController::class, 'store']);

    // this route is for like comment and also for disslike comment
    Route::post('/reaction', [CommentsController::class, 'reactionToComment']);

    //accept comment
    Route::put('/acceptComment/{comment}', [CommentsController::class, 'acceptComment']);
    Route::delete('/destroy/{comment}', [CommentsController::class, 'destroy']);
});
