<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SpaceController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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

// HomePage

Route::get('/homepage', function () {
    return view('pages.home');
});


// Cards
Route::controller(CardController::class)->group(function () {
    Route::get('/homepage/cards', 'list')->name('cards');
    Route::get('/homepage/cards/{id}', 'show');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/profile/{id}','show');
    Route::get('/profile/{id}/editUser','editUser');
    Route::post('/profile/edit', 'edit')->name('edit');
    Route::delete('/api/profile/{id}', 'delete');
});

Route::controller(UserController::class)->group(function() {
    Route::get('api/profile', [UserController::class, 'search']);
});

Route::post('space/add',[SpaceController::class, 'add']);

// API
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
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
