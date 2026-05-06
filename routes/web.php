<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

use App\Http\Controllers\AuthController;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('links', LinkController::class);
    Route::post('links/bulk-update-destination', [LinkController::class, 'bulkUpdateDestination'])->name('links.bulkUpdateDestination');

    Route::resource('domains', DomainController::class);
    Route::post('domains/{domain}/toggle', [DomainController::class, 'toggleActive'])->name('domains.toggle');

    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');


});

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Universal Shortlink Redirect (must be the last route)
Route::get('/{slug}', RedirectController::class)->where('slug', '.*');
