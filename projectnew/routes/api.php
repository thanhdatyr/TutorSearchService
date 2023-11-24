<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\Member\BlogController;
use App\Http\Controllers\Api\Member\MemberController;
use App\Http\Controllers\Api\Member\MemberVipController;
use App\Http\Controllers\Api\Tutor\TutorController;
use App\Http\Controllers\Api\TutorApiController;
use App\Models\Member;
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
Route::post('member/wishlist',[MemberController::class,'addToWishlist']); 
Route::get('member/get/list/wish/{id}',[MemberController::class,'getListWish']); 
Route::post('member/search',[MemberController::class,'searchTutor']); 
Route::post('member/payment',[MemberController::class,'paymentMomo']); 

Route::get('blog',[BlogController::class,'getAllBlog']);
Route::get('view/list/tutor',[TutorApiController::class,'getAllTutor']);
Route::get('view/tutor/{id}',[TutorApiController::class,'viewInfoTutor']);

//Member vip
Route::post('member/vip/rate',[MemberVipController::class,'rateTutor']);
Route::post('member/vip/comment',[MemberVipController::class,'commentTutor']);
Route::get('member/vip/get/rate/{id}',[MemberVipController::class,'getRateTutor']);
Route::get('member/vip/get/comment/{id}',[MemberVipController::class,'getComment']);
Route::post('member/vip/search',[MemberVipController::class,'search']);

Route::post('tutor/register',[TutorController::class,'registerTutor']);
Route::post('tutor/login',[TutorController::class,'loginTuor']);
Route::post('tutor/update',[TutorController::class,'updateTutor']);
Route::post('tutor/add/wishlist/blog',[TutorController::class,'addTowishlistBlog']);
Route::get('tutor/get/wishlist/blog/{id}',[TutorController::class,'getListBlog']);
Route::post('tutor/search',[TutorController::class,'searchBlog']);
Route::post('tutor/makeappoint',[TutorApiController::class,'makeAppoiment']);  
Route::get('tutor/list/appoint/{id}',[TutorApiController::class,'getlistAppoint']);
Route::get('tutor/delete/appoint/{id}',[TutorApiController::class,'deleteAppoint']);

Route::get('member/get/appointment/{id}',[MemberController::class,'getAppointment']);
Route::post('member/appointment/destroy',[MemberController::class,'destroyAppointment']);
Route::get('member/appointment/detail/{id}',[MemberController::class,'detailAppointment']);
Route::get('member/appointment/accept/{id}',[MemberController::class,'acceptAppointment']);

Route::post('forgot/password',[AdminController::class,'forgotPassword']); 
Route::post('password/new',[AdminController::class,'newPassword']);

Route::post('admin/login',[AdminController::class,'login']); 
Route::get('admin/list/tutor',[AdminController::class,'getaccountTutor']);
Route::get('admin/tutor/detail/{id}',[AdminController::class,'detailTutor']);
Route::get('admin/accept/tutor/{id}',[AdminController::class,'acceptTutor']);
Route::get('admin/list/blog',[AdminController::class,'getBlog']);
Route::get('admin/accept/blog/{id}',[AdminController::class,'acceptBlog']);
Route::get('admin/count/member',[AdminController::class,'countMember']);
Route::get('admin/statistical',[AdminController::class,'statisticalPage']);
Route::get('admin/tutor/refuse/{id}',[AdminController::class,'refuseTutor']);
Route::get('admin/blog/refuse/{id}',[AdminController::class,'refuseBlog']);