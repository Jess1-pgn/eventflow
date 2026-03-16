<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteEventController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StaffCheckInController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/events', [PublicEventController::class, 'index'])->name('public.events.index');
Route::get('/events/{event:seo_slug}', [PublicEventController::class, 'show'])->name('public.events.show');
Route::get('/events/{event:seo_slug}/checkout', [CheckoutController::class, 'show'])->name('public.checkout.show');
Route::post('/events/{event:seo_slug}/checkout', [CheckoutController::class, 'store'])->name('public.checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('public.checkout.success');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function (): void {
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::post('/events/{event}/duplicate', [EventController::class, 'duplicate'])->name('events.duplicate');
        Route::post('/events/{event}/archive', [EventController::class, 'archive'])->name('events.archive');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

        Route::get('/check-ins', [StaffCheckInController::class, 'index'])->name('check-ins.index');
        Route::post('/check-ins', [StaffCheckInController::class, 'store'])->name('check-ins.store');
        Route::post('/check-ins/{ticket}/override', [StaffCheckInController::class, 'override'])->name('check-ins.override');
    });

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::post('/events/{event:seo_slug}/favorite', [FavoriteEventController::class, 'store'])->name('public.events.favorite');
    Route::delete('/events/{event:seo_slug}/favorite', [FavoriteEventController::class, 'destroy'])->name('public.events.unfavorite');
});

Route::get('/locale/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['en', 'fr', 'ar'], true), 404);
    session(['locale' => $locale]);
    return back();
})->name('locale.switch');

require __DIR__.'/auth.php';
