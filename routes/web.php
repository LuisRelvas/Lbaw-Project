<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GroupController;

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

// Home
Route::redirect('/', '/login');

// Homepage
Route::group(['middleware' => 'auth'], function () {
    Route::get('/homepage/search', [UserController::class, 'searchPage'])->name('search');
});

Route::get('/homepage', function () {
    return view('pages.home');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});


// Users
Route::controller(UserController::class)->group(function () {
    Route::get('/profile/{id}','show');
    Route::get('/api/profile','search');
    Route::post('/profile/edit', 'edit')->name('edit');
    Route::get('/profile/{id}/editUser','editUser');
    Route::delete('/api/profile/{id}', 'delete');
    Route::post('/profile/follow/{id}', 'follow');
    Route::delete('/profile/unfollow/{id}', 'unfollow');

});


// Spaces
Route::controller(SpaceController::class) ->group(function() {
    Route::post('/space/add','add');
    Route::get('/space/{id}', 'show');
    Route::put('/space/{id}', 'edit');
    Route::get('/homepage','list');
    Route::delete('/api/space/{id}', 'delete');
    Route::get('/api/space', 'search');
});

// Comments
Route::put('/comment/edit', [CommentController::class, 'edit']);

Route::controller(CommentController::class) ->group(function() {
    Route::post('/comment/create', 'create');
    Route::delete('/api/comment/{id}', 'delete');
});


Route::post('/group/add', [GroupController::class, 'add']);
Route::get('/group/{id}', [GroupController::class, 'show']);
Route::put('/group/edit', [GroupController::class, 'edit']);
Route::delete('/api/group/{id}', [GroupController::class, 'delete']);
Route::post('/group/join', [GroupController::class, 'join']);
Route::delete('/group/leave',[GroupController::class,'leave_group']);
Route::delete('/api/group/{id}',[GroupController::class,'remove_member']);



// Admin
Route::controller(AdminController::class) ->group(function() {
Route::get('/admin','show');
Route::post('/profile/block/{id}','block');
Route::delete('/profile/unblock/{id}','unblock');
});






