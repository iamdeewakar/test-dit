<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\exportController;
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

Route::get('/home', function () {
    return view('welcome');
})->name('home');
Route::get('/register',[AuthController::class,'showRegisterPage']);
Route::get('/login',[AuthController::class,'showLoginPage']);
Route::post('/login',[AuthController::class,'login'])->name('user.login');
Route::post('/register',[AuthController::class,'createUser'])->name('user.register');

Route::get('/digital_clock',function(){
    return view('digital_clock');
});

Route::get('/hierarchical-data', [PersonController::class, 'showHierarchy'])->name('hierarchical.data');
Route::get('/export-leads', [exportController::class,'exportLeads'])->name('export.leads');
Route::get('/export', function () {
    return view('export');
});