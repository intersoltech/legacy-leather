<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TrackOrderController;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

Route::view('/', 'index')->name('home');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/policies', 'policies')->name('policies');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');

/*
|--------------------------------------------------------------------------
| PRODUCT
|--------------------------------------------------------------------------
*/

Route::get('/product/{id}', [ProductController::class, 'show'])
    ->name('product.show');

/*
| ⚠️ DO NOT REMOVE
| product.blade.php safe fallback
*/
Route::get('/product', function () {
    return view('product', ['product' => null]);
})->name('product');

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/place', [CheckoutController::class, 'place'])
    ->name('checkout.place');

Route::get('/thank-you', [CheckoutController::class, 'thankYou'])
    ->name('thankyou');

/*
|--------------------------------------------------------------------------
| TRACK ORDER
|--------------------------------------------------------------------------
*/

Route::get('/track-order', [TrackOrderController::class, 'index'])
    ->name('track.order');

Route::post('/track-order', [TrackOrderController::class, 'track'])
    ->name('track.order.submit');

/*
|--------------------------------------------------------------------------
| AUTH (BREEZE)
|--------------------------------------------------------------------------
*/

if (file_exists(__DIR__ . '/auth.php')) {
    require __DIR__ . '/auth.php';
}

/*
|--------------------------------------------------------------------------
| DASHBOARD / PROFILE
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [\App\Http\Controllers\UserDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // User Orders
    Route::get('/my-orders/{order}', [\App\Http\Controllers\UserDashboardController::class, 'showOrder'])
        ->name('user.orders.show');
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin']) // Admin routes require admin access
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        // PRODUCTS
        Route::get('/products', [AdminProductController::class, 'index'])
            ->name('admin.products.index');

        Route::get('/products/create', [AdminProductController::class, 'create'])
            ->name('admin.products.create');

        Route::post('/products', [AdminProductController::class, 'store'])
            ->name('admin.products.store');

        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])
            ->name('admin.products.edit');

        Route::put('/products/{product}', [AdminProductController::class, 'update'])
            ->name('admin.products.update');

        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])
            ->name('admin.products.destroy');

        // CATEGORIES
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)
            ->except(['show'])
            ->names('admin.categories');

        // BANNERS
        Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)
            ->except(['show'])
            ->names('admin.banners');

        // SITE SETTINGS
        Route::get('/settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'index'])
            ->name('admin.settings.index');
        Route::put('/settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'update'])
            ->name('admin.settings.update');

        // SOCIAL LINKS
        Route::get('/social-links', [\App\Http\Controllers\Admin\SocialLinkController::class, 'index'])
            ->name('admin.social-links.index');
        Route::post('/social-links', [\App\Http\Controllers\Admin\SocialLinkController::class, 'store'])
            ->name('admin.social-links.store');
        Route::put('/social-links/{socialLink}', [\App\Http\Controllers\Admin\SocialLinkController::class, 'update'])
            ->name('admin.social-links.update');
        Route::delete('/social-links/{socialLink}', [\App\Http\Controllers\Admin\SocialLinkController::class, 'destroy'])
            ->name('admin.social-links.destroy');

        // ORDERS
        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('admin.orders.index');

        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->name('admin.orders.show');

        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('admin.orders.status');

        // USERS MANAGEMENT (Admin only)
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('admin.users.index');
        Route::post('/users/{user}/admin-status', [\App\Http\Controllers\Admin\UserController::class, 'updateAdminStatus'])
            ->name('admin.users.update-status');
    });
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
