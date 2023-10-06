<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::post('client/login',[LoginController::class, 'clientLogin'])->name('clientLogin');
Route::group( ['prefix' => 'client','middleware' => ['auth:client-api','scopes:client'] ],function(){
    // authenticated staff routes here 
    Route::get('dashboard',[LoginController::class, 'clientDashboard']);
});