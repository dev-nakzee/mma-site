<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Auth\RegisterController;

Route::post('user/login',[LoginController::class, 'login'])->name('user.login');
Route::post('user/register',[RegisterController::class, 'register'])->name('user.register');

Route::group( ['prefix' => 'user','middleware' => ['auth:user-api','scopes:user'] ],function(){
   // authenticated staff routes here 
    Route::get('dashboard',[DashboardController::class, 'index']);
});