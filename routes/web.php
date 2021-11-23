<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/',[App\Http\Controllers\EmailFetchController::class,'connectPage']);
Route::post('connect',[App\Http\Controllers\EmailFetchController::class,'index'])->name('connect');
Route::get('emails', function () {
        return view('emails');
    })->name('emails');
Route::post('search',[App\Http\Controllers\EmailFetchController::class,'custom_search'])->name('search');