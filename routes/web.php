<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;

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

Broadcast::routes(['middleware' => ['auth:sanctum']]);
Broadcast::routes();


Route::group(['middleware' => 'auth'], function () {

    Route::get('/homepage/search', [UserController::class, 'search_exact'])->name('search');
});

Route::get('/homepage', function () {
    return view('pages.home');
});

// About Us
Route::get('/about', function () {
    return view('pages.about');
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



// Spaces
Route::controller(SpaceController::class) ->group(function() {
    Route::post('/space/add','add');
    Route::get('/space/{id}', 'show');
    Route::put('/space/{id}', 'edit');
    Route::get('/homepage','list');
    Route::delete('/api/space/{id}', 'delete');
    Route::get('/api/space', 'search');
    Route::post('/space/like','like_on_spaces');
    Route::delete('/space/unlike','unlike_on_spaces');
});

// Comments
Route::put('/comment/edit', [CommentController::class, 'edit']);

Route::controller(CommentController::class) ->group(function() {
    Route::post('/comment/create', 'create');
    Route::delete('/api/comment/{id}', 'delete');
    Route::post('/comment/like','like_on_comments');
    Route::delete('/comment/unlike','unlike_on_comments');
});

Route::get('/messages',[MessageController::class,'list']);
Route::post('/messages/send',[MessageController::class,'send']);
Route::get('/messages/{id}',[MessageController::class,'show']);
Route::post('/messages/receive',[MessageController::class,'receive']);

Route::post('/group/add', [GroupController::class, 'add']);
Route::get('/group/{id}', [GroupController::class, 'show']);
Route::put('/group/edit', [GroupController::class, 'edit']);
Route::delete('/api/group/{id}', [GroupController::class, 'delete']);
Route::post('/group/join', [GroupController::class, 'join']);
Route::delete('/group/leave',[GroupController::class,'leave_group']);
Route::delete('/api/group/{id}',[GroupController::class,'remove_member']);
Route::get('/group',[GroupController::class,'list']);
Route::post('/group/joinrequest',[GroupController::class,'join_request']);
Route::post('/group/joinrequest/{id}',[GroupController::class,'accept_join_request']);
Route::delete('/group/joinrequest',[GroupController::class,'decline_join_request']);


Route::controller(UserController::class)->group(function () {
    Route::get('/profile/{id}','show');
    Route::get('/api/profile','search');
    Route::post('/profile/edit', 'edit')->name('edit');
    Route::get('/profile/{id}/editUser','editUser');
    Route::delete('api/profile/{id}', 'delete');
    Route::post('/profile/follow/{id}', 'follow');
    Route::delete('/profile/unfollow/{id}', 'unfollow');
    Route::post('/profile/followsrequest', [UserController::class, 'follow_request']);
    Route::post('/profile/followsrequest/{id}', [UserController::class, 'accept_follow_request']);
    Route::delete('/profile/followsrequest', [UserController::class, 'decline_follow_request']);

});

// Admin
Route::controller(AdminController::class) ->group(function() {
Route::get('/admin','show');
Route::post('/profile/block/{id}','block');
Route::delete('/profile/unblock/{id}','unblock');
});

// Groups
Route::controller(GroupController::class)->group(function () {
    Route::get('/group/{id}', 'show');
    Route::get('/group', 'list');
    Route::post('/group/add', 'add');
    Route::put('/group/edit', 'edit');
    Route::delete('/api/group/{id}', 'delete');
    Route::post('/group/join', 'join');
    Route::delete('/group/leave', 'leave_group');
    Route::delete('/api/group/{id}', 'remove_member');
    Route::post('/group/joinrequest', 'join_request');
    Route::post('/group/joinrequest/{id}', 'accept_join_request');
    Route::delete('/group/joinrequest', 'decline_join_request');
    Route::post('/group/invite', 'invite');
    Route::post('/group/acceptinvite', 'accept_invite');
    Route::delete('/group/declineinvite', 'decline_invite');
});

//Notifications
Route::controller(NotificationController::class)->group(function () {
    Route::get('/notification', 'list');
    Route::delete('api/notification/{id}', 'delete');
    Route::put('/notification/{id}', 'edit');
});






