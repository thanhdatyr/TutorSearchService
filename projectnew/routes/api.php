<?php

use App\Http\Controllers\Api\Member\BlogController;
use App\Http\Controllers\Api\Member\MemberController;
use App\Http\Controllers\Api\Tutor\TutorController;
use App\Http\Controllers\Api\TutorApiController;
use App\Models\Tutor;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get/country',[MemberController::class,'getCountry']);
Route::get('get/district/{id}',[MemberController::class,'getDistrict']);
Route::get('get/class',[BlogController::class,'getClass']);
Route::get('get/subject/{id}',[BlogController::class,'getSubject']);
Route::post('member/register',[MemberController::class,'registerMember']);
Route::post('member/login',[MemberController::class,'loginMember']);
Route::post('member/update',[MemberController::class,'updateMember']);
Route::post('member/post/blog',[BlogController::class,'postBlog']);
Route::get('member/blog/{id}',[BlogController::class,'index']);
Route::get('member/blog/detail/{id}',[BlogController::class,'edit']);
Route::post('member/blog/detail/{id}',[BlogController::class,'update']);
Route::get('member/blog/delete/{id}',[BlogController::class,'destroy']);
Route::post('member/wishlist',[MemberController::class,'addToWishlist']); //*
Route::get('member/get/list/wish/{id}',[MemberController::class,'getListWish']); //*
Route::post('member/search',[MemberController::class,'searchTutor']); //*

Route::get('blog',[BlogController::class,'getAllBlog']);
Route::get('view/list/tutor',[TutorApiController::class,'getAllTutor']);
Route::get('view/tutor/{id}',[TutorApiController::class,'viewInfoTutor']);

Route::post('tutor/register',[TutorController::class,'registerTutor']);
Route::post('tutor/login',[TutorController::class,'loginTuor']);
Route::post('tutor/add/wishlist/blog',[TutorController::class,'addTowishlistBlog']);
Route::get('tutor/get/wishlist/blog/{id}',[TutorController::class,'getListBlog']);
Route::post('tutor/search',[TutorController::class,'searchBlog']);

