<?php

use App\Http\Controllers\PackagingSelectorController;
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

Route::get('/product-packaging-selector', [PackagingSelectorController::class, 'showForm'])->name('product-packaging-selector.form');
Route::post('/product-packaging-selector', [PackagingSelectorController::class, 'processProducts'])->name('product-packaging-selector.process');
