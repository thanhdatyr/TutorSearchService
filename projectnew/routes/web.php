<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/add',[HomeController::class,'index']);
Route::post('/add',[HomeController::class,'postCountry']);
Route::get('district/add',[HomeController::class,'district']);
Route::post('district/add',[HomeController::class,'postDistrict']);
Route::get('class/add',[HomeController::class,'getClass']);
Route::post('class/add',[HomeController::class,'postClass']);
Route::get('subject/add',[HomeController::class,'subject']);
Route::post('subject/add',[HomeController::class,'addSubject']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
