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

// this route is for like comment and also for disslike comment
Route::post('news/reaction/{news}', [NewsController::class, 'reactionToNews'])->name('reactionToNews');


Route::prefix('comments')
->name('comments.')
->group(function () {

    // this route is for store new comment and also for store answer old comment
    Route::post('/save', [CommentsController::class, 'store'])->name('store');

    // this route is for like comment and also for disslike comment
    Route::post('/reaction', [CommentsController::class, 'reactionToComment'])->name('reactionToComment');

    //accept comment
    Route::put('/acceptComment/{comment}', [CommentsController::class, 'acceptComment'])->name('acceptComment');
    Route::delete('/destroy/{comment}', [CommentsController::class, 'destroy'])->name('destroy');
});