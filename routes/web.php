<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MainController;

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

Route::get("/", [MainController::class, 'index'])->name('index');
ROute::get('/basket', [BasketController::class, "basket"])->name('basket');
ROute::get('/basket/place', [BasketController::class, "basketPlace"])->name('basket-place');
ROute::post('/basket/add/{id}', [BasketController::class, "basketAdd"])->name('basket-add');
ROute::post('/basket/remove/{id}', [BasketController::class, "basketRemove"])->name('basket-remove');
Route::get("/categories", [MainController::class, "categories"])->name('categories');
Route::get("/{category}", [MainController::class, "category"])->name('category');
Route::get('/{category}/{product?}', [MainController::class, "product"])->name('product');
