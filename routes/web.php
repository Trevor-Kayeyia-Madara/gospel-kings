<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\VipPackageController;
use App\Http\Controllers\Admin\GuestMinisterController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\VolunteerController;
use App\Http\Controllers\Admin\DonorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\PlatformController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PlatformController::class, 'home'])->name('home');
Route::get('/about', [PlatformController::class, 'about'])->name('about');
Route::get('/david-kasika', [PlatformController::class, 'davidKasika'])->name('david-kasika');
Route::get('/events', [PlatformController::class, 'events'])->name('events.index');
Route::get('/events/{event:slug}', [PlatformController::class, 'showEvent'])->name('events.show');
Route::get('/events/{event:slug}/register', [PlatformController::class, 'register'])->name('events.register');
Route::post('/events/{event:slug}/register', [PlatformController::class, 'storeRegistration'])->name('events.register.store');
Route::get('/registrations/{registration}/success', [PlatformController::class, 'registrationSuccess'])->name('events.registration.success');
Route::get('/tickets/{registrationNumber}/verify', [PlatformController::class, 'verifyTicket'])->name('tickets.verify');
Route::get('/tickets/{ticketNumber}/qr', [App\Http\Controllers\TicketController::class, 'showQr'])->name('tickets.qr');
Route::get('/sponsors', [PlatformController::class, 'sponsors'])->name('sponsors.index');
Route::get('/guest-ministers', [PlatformController::class, 'guestMinisters'])->name('guest-ministers.index');
Route::get('/galleries', [PlatformController::class, 'galleries'])->name('galleries.index');
Route::get('/galleries/{gallery:slug}', [PlatformController::class, 'showGallery'])->name('galleries.show');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::resource('events', EventAdminController::class)->except(['index', 'show']);
    Route::get('/events', [EventAdminController::class, 'index'])->name('events.index');

    Route::middleware('role:super-admin,ministry-admin')->group(function () {
        Route::resource('categories', EventCategoryController::class);
        Route::resource('vip-packages', VipPackageController::class);
        Route::resource('guest-ministers', GuestMinisterController::class);
        Route::resource('sponsors', SponsorController::class);
        Route::resource('announcements', AnnouncementController::class);
        Route::resource('galleries', GalleryController::class);
        Route::resource('media', MediaController::class);
        Route::resource('volunteers', VolunteerController::class);
        Route::resource('donors', DonorController::class);
        Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
        Route::get('reports/registrations', [ReportController::class, 'registrations'])->name('reports.registrations');
        Route::get('reports/registrations/export', [ReportController::class, 'exportRegistrations'])->name('reports.registrations.export');
        Route::get('reports/finance', [ReportController::class, 'finance'])->name('reports.finance');
        Route::get('reports/finance/export', [ReportController::class, 'exportFinance'])->name('reports.finance.export');
    });

    Route::get('/check-in', [CheckInController::class, 'index'])->name('check-in.index');
    Route::post('/check-in/search', [CheckInController::class, 'search'])->name('check-in.search');
    Route::post('/check-in/{ticket}', [CheckInController::class, 'store'])->name('check-in.store');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::post('/api/mpesa/callback', [App\Http\Controllers\MpesaController::class, 'callback'])->name('api.mpesa.callback');
Route::post('/api/mpesa/query/{payment}', [App\Http\Controllers\MpesaController::class, 'query'])->name('api.mpesa.query');
