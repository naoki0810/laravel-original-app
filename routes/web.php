<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use App\Http\Middleware\NotSubscribed;
use App\Http\Middleware\Subscribed;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [WebController::class, 'index'])->name('top');
Route::resource('shops', ShopController::class);


Route::middleware('auth', 'verified')->group(function () {

    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::controller(UserController::class)->group(function () {
        Route::get('users/mypage', 'mypage')->name('mypage');
        Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
        Route::put('users/mypage', 'update')->name('mypage.update');
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
        Route::delete('users/mypage/delete', 'destroy')->name('mypage.destroy');
        Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');        
    });
    
    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('subscription/create', 'create')->name('subscription.create');
        Route::post('subscription/store', 'store')->name('subscription.store');
        Route::get('subscription/edit', 'edit')->name('subscription.edit');
        Route::put('subscription/update', 'update')->name('subscription.update');
        Route::get('subscription/cancel', 'cancel')->name('subscription.cancel');
        Route::delete('subscription/destroy', 'destroy')->name('subscription.destroy');
    });

    Route::controller(ReservationController::class)->group(function () {
        Route::get('reservations/index', 'index')->name('reservations.index');
        Route::get('reservations/create', 'create')->name('reservations.create');
        Route::post('reservations/store', 'store')->name('reservations.store');
        Route::delete('reservations/destroy/{id}', 'destroy')->name('reservations.destroy');
    });

    Route::controller(FavoriteController::class)->group(function () {
        Route::post('favorite/{shop_id}', 'store')->name('favorites.store');
        Route::delete('favorite/{shop_id}', 'destroy')->name('favorites.destroy');
    });
    
});

require __DIR__.'/auth.php';


