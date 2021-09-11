<?php

use App\Http\Controllers\ResetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\LoginController;


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

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);
Route::get('/logout', [LoginController::class, "logout"])->name('get-logout');

Route::middleware(['auth'])->group(function () {

    Route::group([
        'prefix' => 'person',
        'namespace' => 'Person',
        'as' => 'person.',
    ], function () {
        Route::get('/orders', [\App\Http\Controllers\Person\OrderController::class, "index"])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Person\OrderController::class, "show"])->name('orders.show');
    });

    Route::group([
        'namespace' => 'Admin',
        'prefix' => 'admin',
    ], function () {
        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, "index"])->name('home');
            Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, "show"])->name('show');
        });
        Route::resource('categories', "\App\Http\Controllers\Admin\CategoryController");
        Route::resource('products', '\App\Http\Controllers\Admin\ProductController');
    });
});

Route::get("/", [MainController::class, 'index'])->name('index');

Route::group(['prefix' => 'basket'], function () {
    Route::post('/add/{id}', [BasketController::class, "basketAdd"])->name('basket-add');

    Route::group([
        'middleware' => 'basket_not_empty',
    ], function () {
        Route::get('/', [BasketController::class, "basket"])->name('basket');
        Route::get('/place', [BasketController::class, "basketPlace"])->name('basket-place');
        Route::post('/confirm', [BasketController::class, "basketConfirm"])->name('basket-confirm');
        Route::post('/remove/{id}', [BasketController::class, "basketRemove"])->name('basket-remove');
    });
});


Route::get("/categories", [MainController::class, "categories"])->name('categories');
Route::get("/{category}", [MainController::class, "category"])->name('category');
Route::get('/{category}/{product?}', [MainController::class, "product"])->name('product');

Route::get('reset', [ResetController::class, "reset"])->name('reset');

