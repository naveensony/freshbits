<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::delete('/home/delete/{id}', [HomeController::class, 'deletesingle'])->name('deletesingle');
Route::delete('/home/delete', [HomeController::class, 'deleteall'])->name('deleteall');
Route::get('/home/add', [HomeController::class, 'create'])->name('create');
Route::post('/home/store', [HomeController::class, 'store'])->name('store');
Route::get('/home/edit/{id}', [HomeController::class, 'edit'])->name('edit');
Route::post('/home/update', [HomeController::class, 'update'])->name('update');
