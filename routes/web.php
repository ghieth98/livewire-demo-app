<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\CategoriesList;
use App\Http\Livewire\OrderForm;
use App\Http\Livewire\OrderList;
use App\Http\Livewire\ProductForm;
use App\Http\Livewire\ProductsList;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/categories', CategoriesList::class)->name('categories.index');
    Route::get('/products', ProductsList::class)->name('products.index');
    Route::get('/products/create', ProductForm::class)->name('products.create');
    Route::get('/products/{product}', ProductForm::class)->name('products.edit');
    Route::get('/orders', OrderList::class)->name('orders.index');
    Route::get('orders/create', OrderForm::class)->name('orders.create');
    Route::get('/orders/{order}', OrderForm::class)->name('orders.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
