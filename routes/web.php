<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\LinkController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')
    ->middleware('admin.basic')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('admin.dashboard');

        Route::post('links/bulk-update-destination', [LinkController::class, 'bulkUpdateDestination'])
            ->name('admin.links.bulkUpdateDestination');
        Route::resource('links', LinkController::class)->names('admin.links')->except(['show']);

        Route::post('domains/{domain}/toggle', [DomainController::class, 'toggle'])->name('admin.domains.toggle');
        Route::resource('domains', DomainController::class)->names('admin.domains')->except(['show']);

        Route::get('analytics', [AnalyticsController::class, 'index'])->name('admin.analytics.index');
    });

Route::get('/{slug}', RedirectController::class)
    ->where('slug', '[^/]+');
