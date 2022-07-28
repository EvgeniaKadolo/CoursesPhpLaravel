<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [IndexController::class, 'index']);
Route::get('/courses/{id}', [IndexController::class, 'courses']);
Route::get('/course/{id}', [IndexController::class, 'course'])->name('course');
Route::get('/add', [IndexController::class, 'add'])->middleware('auth');
Route::get('/change/{course}', [IndexController::class, 'change'])->name('change')->middleware('auth');
Route::post('/edit/{course}', [IndexController::class, 'edit'])->name('edit')->middleware('auth');
Route::post('/add', [IndexController::class, 'store'])->name('store')->middleware('auth');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/list_records/{course}', [IndexController::class, 'list_records'])->name('list_records')->middleware('auth');
Route::post('/filter', [IndexController::class, 'filter'])->name('filter');
Route::delete('/delete/{course}', [IndexController::class, 'delete'])->name('delete')->middleware('auth');
Route::post('/record/{course}', [IndexController::class, 'record'])->name('record')->middleware('auth');
Route::post('/unsubscribe/{course}', [IndexController::class, 'unsubscribe'])->name('unsubscribe')->middleware('auth');
Route::delete('/delete_user/{user}/{course}', [IndexController::class, 'delete_user'])->name('delete_user')->middleware('auth');
