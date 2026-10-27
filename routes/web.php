<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::post('/contact', [PublicController::class, 'contact'])->middleware('throttle:5,1')->name('contact.store');
Route::get('/pages/{page:slug}', [PublicController::class, 'page'])->name('pages.show');
Route::get('/news', [PublicController::class, 'news'])->name('posts.index');
Route::get('/news/{post:slug}', [PublicController::class, 'post'])->name('posts.show');
Route::redirect('/dashboard', '/admin');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('pages', PageController::class)->except('show');
    Route::resource('posts', PostController::class)->except('show');
    Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::patch('messages/{message}/read', [ContactMessageController::class, 'markRead'])->name('messages.read');
    Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
    Route::resource('users', UserController::class)->except('show')->middleware('admin');
    Route::get('audit', [AuditLogController::class, 'index'])->name('audit.index');
    Route::get('settings', [SiteSettingController::class, 'edit'])->name('settings.edit')->middleware('admin');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update')->middleware('admin');
});

Route::get('/{page:slug}', [PublicController::class, 'page'])->name('pages.pretty');
