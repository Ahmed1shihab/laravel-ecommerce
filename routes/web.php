<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

Route::view('/search', 'search-results-algolia');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::post('/SaveForLater', [SaveForLaterController::class, 'index'])->name('saveForLater.index');
Route::post('cart/switchToSaveForLater/{product}', [CartController::class, 'switchToSaveForLater'])->name('cart.switchToSaveForLater');
Route::delete('SaveForLater/{product}', [SaveForLaterController::class, 'destroy'])->name('saveForLater.destroy');
Route::post('switchToCart/{product}', [SaveForLaterController::class, 'switchToCart'])->name('saveForLater.switchToCart');

Route::post('/coupon', [CouponsController::class, 'store'])->name('coupon.store');
Route::delete('/coupon', [CouponsController::class, 'destroy'])->name('coupon.destory');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user_dashboard.dashboard');
    })->name('dashboard');

    Route::put('/my-profile', [UserController::class, 'update'])->name('user.update');

    Route::get('/dashboard/my-orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/dashboard/my-orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
