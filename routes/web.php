<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['IsAdmin'],
], function () {
    Route::get('/', [AdminController::class, 'index'])->name('index.admin'); // لوحة التحكم  
    Route::get('/update-password', [AdminController::class, 'showUpdatePassword'])->name('show-update-password');
    Route::post('/update-password', [AdminController::class, 'updatePassword'])->name('update-password');

    Route::resource('/books', BooksController::class);
    Route::post('/upload/blogs', [UploadController::class, 'upload_image_book'])->name('upload.books'); 

    // Route::resource(''Pr);
});

Route::get('/', [UserController::class, 'index'])->name('index.user');

// Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
Route::get('/profile/{id}', [ProfileController::class, 'profile'])->name('user.profile');
Route::get('/edit_profile_form/{id}', [ProfileController::class, 'edit_profile_form'])->name('user.edit_profile_form');
Route::post('/upload/profile/{id}', [ProfileController::class, 'upload_profile_photo'])->name('upload.profile'); 
Route::post('/upload/profile_cover/{id}', [ProfileController::class, 'upload_profile_cover'])->name('upload.cover'); 
Route::put('/update_profile/{id}', [ProfileController::class, 'update_profile'])->name('update.profile'); 